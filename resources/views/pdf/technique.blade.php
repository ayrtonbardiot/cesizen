<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Documentation technique</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        h1, h2 {
            margin-bottom: 0;
        }
        h2 {
            margin-top: 30px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }
        .method {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        .method-title {
            font-weight: bold;
        }
        .param {
            margin-left: 10px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h1>Documentation Technique</h1>
    <p>Généré le : {{ $generatedAt }}</p>

    @forelse($controllers as $controller)
        <h2>{{ $controller['class'] }}</h2>

        @forelse($controller['methods'] as $method)
            <div class="method">
                <div class="method-title">Méthode {{ $method['name'] }}()</div>
                <div><strong>Description :</strong> {{ $method['description'] ?? '-' }}</div>
                <div><strong>Module :</strong> {{ $method['module'] ?? '-' }}</div>
                <div><strong>Retour :</strong> {{ $method['return'] ?? '-' }}</div>

                @if (!empty($method['params']))
                    <div><strong>Paramètres :</strong></div>
                    <ul>
                        @foreach ($method['params'] as $param)
                            <li class="param">{{ $param }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @empty
            <p><em>Aucune méthode publique détectée.</em></p>
        @endforelse

    @empty
        <p>Aucun contrôleur détecté.</p>
    @endforelse
</body>
</html>
