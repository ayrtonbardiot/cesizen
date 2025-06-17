<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de tests</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
            table-layout: fixed;
        }
        table.pv-signature td {
            width: 33%;
            vertical-align: top;
        }
        table.pv-signature td:nth-child(2) {
            width: 20%;
        }
        table.pv-signature td:nth-child(3) {
            width: 20%;
        }
        th, td {
            border: 1px solid #444;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            word-break: break-word;
            white-space: pre-wrap;
        }
        /* Largeur des colonnes pour les tableaux */
        th:nth-child(1), td:nth-child(1) { width: 5%; }    /* # */
        th:nth-child(2), td:nth-child(2) { width: 25%; }   /* Action */
        th:nth-child(3), td:nth-child(3) { width: 25%; }   /* Attendu */
        th:nth-child(4), td:nth-child(4) { width: 15%; }   /* Résultat */
        th:nth-child(5), td:nth-child(5) { width: 30%; }   /* Message */

        .page-break {
            page-break-after: always;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>
<body>

@foreach ($fiches as $index => $fiche)
    @if ($index === 0)
        <header>
            <h1>Sommaire</h1>
            <p>Rapport généré le {{ $generatedAt }}</p>
        </header>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fiche</th>
                    <th>Module</th>
                    <th>Responsable</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fiche['tests'] as $i => $line)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $line['nom'] }}</td>
                        <td>{{ $line['action'] }}</td>
                        <td>{{ $line['attendu'] }}</td>
                        <td>{{ $line['resultat'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <footer>
            Page <span class="pagenum"></span>
        </footer>
    @else
        <header>
            <h1>FICHE DE TEST</h1>
        </header>

        <p><strong>N° FICHE :</strong> {{ $fiche['fiche'] }}</p>
        <p><strong>Nom projet :</strong> {{ $fiche['projet'] ?? '—' }}</p>
        <p><strong>Module testé :</strong> {{ $fiche['module'] ?? '—' }}</p>
        <p><strong>Responsable test :</strong> {{ $fiche['responsable'] ?? '—' }}</p>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Action</th>
                    <th>Attendu</th>
                    <th>Résultat</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fiche['tests'] as $i => $test)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $test['action'] }}</td>
                        <td>{{ $test['attendu'] }}</td>
                        <td>{{ $test['resultat'] }}</td>
                        <td>{{ $test['message'] ? e($test['message']) : '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

<div class="page-break"></div>

<header>
    <h1>Procès-Verbal de Validation Finale</h1>
    <p>Rapport généré le {{ $generatedAt }}</p>
</header>

<p><strong>Nom du projet :</strong> CESIZen</p>
<p><strong>Équipe responsable :</strong> Équipe CESIZen</p>

<h3>Modules validés :</h3>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom de la fiche</th>
            <th>Module</th>
            <th>Responsable</th>
            <th>Résultat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fiches as $i => $fiche)
            @if ($fiche['fiche'] !== 'SOMMAIRE' && $fiche['fiche'] !== 'PV_RECETTE')
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $fiche['fiche'] }}</td>
                    <td>{{ $fiche['module'] ?? '—' }}</td>
                    <td>{{ $fiche['responsable'] ?? '—' }}</td>
                    <td>
                        {{ collect($fiche['tests'])->contains(fn($t) => $t['resultat'] === 'Echec') ? 'Echec' : 'Succès' }}
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<p style="margin-top: 40px;"><strong>Commentaire final :</strong></p>
<p style="min-height: 80px; border: 1px solid #000; padding: 10px;">&nbsp;</p>

<table class="pv-signature" style="margin-top: 40px;">
    <tr>
        <td><strong>Nom du valideur :</strong><br><br>_________________________</td>
        <td><strong>Date :</strong><br><br>____ / ____ / ______</td>
        <td><strong>Signature :</strong><br><br>______________________</td>
    </tr>
</table>

<footer>
    Page <span class="pagenum"></span>
</footer>

</body>
</html>
