<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        {!! file_get_contents(public_path('css/pdf-certificate.css')) !!}
    </style>
</head>

<body>
    {!! $content['content'] ?? 'N/A' !!}
</body>

</html>