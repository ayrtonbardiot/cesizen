<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateTechnicalDoc extends Command
{
    protected $signature = 'docs:generate-technique {--output=}';
    protected $description = 'Génère une documentation technique PDF des contrôleurs.';

    public function handle(): int
    {
        $this->info('Analyse des contrôleurs...');

        $controllers = $this->extractControllers(app_path('Http/Controllers'));

        $generatedAt = now()->format('d/m/Y H:i:s');

        $pdf = Pdf::loadView('pdf.technique', [
            'controllers' => $controllers,
            'generatedAt' => $generatedAt,
        ]);
        $pdf->setPaper('A4', 'portrait');

        $output = $this->option('output') ?? "DOC-TECHNIQUE_LAST.pdf";
        $output = base_path($output);

        File::ensureDirectoryExists(dirname($output));
        if (File::exists($output)) {
            File::delete($output);
        }

        $pdf->save($output);

        $this->info("PDF généré avec succès : {$output}");
        return 0;
    }

    private function extractControllers(string $dir): array
    {
        $controllers = [];
        $files = File::allFiles($dir);

        foreach ($files as $file) {
            $content = File::get($file);

            preg_match('/namespace (.*?);/', $content, $nsMatch);
            preg_match('/class (\w+)/', $content, $classMatch);

            $namespace = $nsMatch[1] ?? 'App\\Http\\Controllers';
            $class = $classMatch[1] ?? 'UnknownController';
            $fullClass = "$namespace\\$class";

            preg_match_all('/(?:\/\*\*(.*?)\*\/)?\s*public function (\w+)\((.*?)\)/s', $content, $matches, PREG_SET_ORDER);

            $methods = collect($matches)->map(function ($match) {
                $doc = $match[1] ?? '';
                return [
                    'name' => $match[2],
                    'description' => $this->extractTag($doc, 'description') ?? '-',
                    'module' => $this->extractTag($doc, 'module') ?? '-',
                    'params' => $this->extractTags($doc, 'param'),
                    'return' => $this->extractTag($doc, 'return') ?? '-',
                ];
            })->toArray();

            $controllers[] = [
                'class' => $fullClass,
                'methods' => $methods,
            ];
        }

        return $controllers;
    }

    private function extractTag(string $docblock, string $tag): ?string
    {
        preg_match("/@$tag (.*)/", $docblock, $matches);
        return $matches[1] ?? null;
    }

    private function extractTags(string $docblock, string $tag): array
    {
        preg_match_all("/@$tag (.*)/", $docblock, $matches);
        return $matches[1] ?? [];
    }
}
