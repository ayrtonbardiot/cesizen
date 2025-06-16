<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\Process\Process;

class GenerateTestFiches extends Command
{
    protected $signature = 'tests:generate-fiches {--output=}';
    protected $description = 'Génère un rapport PDF complet des fiches de tests avec les résultats.';

    public function handle(): int
    {   
        ini_set('memory_limit', '512M'); 
        $this->info('Exécution des tests PHPUnit...');

        $logPath = storage_path('logs/phpunit.junit.xml');
        File::ensureDirectoryExists(dirname($logPath));

        $process = new Process(
            ['php', 'artisan', 'test', '--env=testing', '--log-junit=' . $logPath],
            base_path(),
            [
                // simule environnement "testing"
                'APP_ENV' => 'testing',
                'APP_DEBUG' => 'true',
                'SESSION_DRIVER' => 'array',
                'SESSION_SECURE_COOKIE' => 'false',
                'DB_CONNECTION' => 'sqlite',
                'DB_DATABASE' => ':memory:',
            ] + $_ENV 
        );
        $process->setTty(Process::isTtySupported()); // Active couleurs si dispo
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
        
        if (!File::exists($logPath)) {
            $this->error('Le fichier phpunit.junit.xml n\'a pas été généré.');
            return 1;
        }

        $results = $this->parseJUnitXml($logPath);
        $tests = $this->extractTestAnnotations(base_path('tests/Feature'), $results);

        $this->info('Génération du PDF...');

        $generatedAt = now()->format('d/m/Y H:i:s');

        $summary = [
            'fiche' => 'SOMMAIRE',
            'projet' => null,
            'module' => null,
            'responsable' => null,
            'tests' => collect($tests)->map(fn($fiche) => [
                'nom' => $fiche['fiche'],
                'action' => $fiche['module'] ?? '-',
                'attendu' => $fiche['responsable'] ?? '-',
                'resultat' => collect($fiche['tests'])->contains(fn($t) => $t['resultat'] === 'Echec') ? 'Echec' : 'Succès',
                'message' => collect($fiche['tests'])->pluck('message')->filter()->implode("\n---\n"),
            ])->toArray(),
        ];

        array_unshift($tests, $summary);

        $pdf = Pdf::loadView('pdf.fiches', [
            'fiches' => $tests,
            'generatedAt' => $generatedAt,
        ]);
        $pdf->setPaper('A4', 'portrait');

        $output = $this->option('output') ?? "FICHES-TESTS_LAST.pdf";
        $output = base_path($output);

        if (File::exists($output)) {
            File::delete($output);
        }

        File::ensureDirectoryExists(dirname($output));
        $pdf->save($output);

        $this->info("PDF généré avec succès : {$output}");
        return 0;
    }

    private function parseJUnitXml(string $path): array
    {
        $xml = simplexml_load_file($path);
        $results = [];

        foreach ($xml->xpath('//testcase') as $case) {
            $class = str_replace('.', '\\', (string) $case['classname']);
            $method = (string) $case['name'];
            $key = "$class@$method";

            $results[$key] = [
                'status' => isset($case->failure) ? 'Echec' : 'Succès',
                'message' => isset($case->failure) ? (string) $case->failure : '',
            ];
        }

        return $results;
    }

    private function extractTestAnnotations(string $dir, array $results): array
    {
        $fiches = [];
        $files = File::allFiles($dir);

        foreach ($files as $file) {
            $content = File::get($file);

            preg_match('/namespace (.*?);/', $content, $nsMatch);
            preg_match('/class (\w+)/', $content, $classMatch);

            $namespace = $nsMatch[1] ?? 'Tests\\Feature';
            $classShort = $classMatch[1] ?? 'UnknownTest';
            $className = "$namespace\\$classShort";

            preg_match_all('/\/\*\*(.*?)\*\/(\s*)public function (test.*?)\(/s', $content, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $doc = $match[1];
                $method = $match[3];
                $key = "$className@$method";

                $ficheId = $classShort;

                $fiche = &$fiches[$ficheId];
                $fiche['fiche'] = $ficheId;
                $fiche['projet'] = $this->extractTag($doc, 'projet');
                $fiche['module'] = $this->extractTag($doc, 'module');
                $fiche['responsable'] = $this->extractTag($doc, 'responsable');
                $fiche['tests'][] = [
                    'nom' => $method,
                    'action' => $this->extractTag($doc, 'action') ?? $method,
                    'attendu' => $this->extractTag($doc, 'attendu') ?? '—',
                    'resultat' => $results[$key]['status'] ?? 'Inconnu',
                    'message' => $results[$key]['message'] ?? '',
                ];
            }
        }

        return array_values($fiches);
    }

    private function extractTag(string $docblock, string $tag): ?string
    {
        preg_match("/@$tag (.*)/", $docblock, $matches);
        return $matches[1] ?? null;
    }
}
