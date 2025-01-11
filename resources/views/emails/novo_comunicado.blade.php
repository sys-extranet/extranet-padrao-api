<!DOCTYPE html>
<html>
<head>
    <title>Novo Comunicado</title>
</head>
<body>
    <h1>{{ $comunicado->titulo }}</h1>
    <p>{{ $comunicado->conteudo }}</p>
    <p>Publicado em: {{ $comunicado->created_at->format('d/m/Y H:i') }}</p>
</body>
</html>
