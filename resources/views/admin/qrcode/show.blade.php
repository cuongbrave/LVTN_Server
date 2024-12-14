<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code for Test</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container my-auto">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="mb-4">QR Code for Test: {{ $test->name }}</h1>
                <div class="mb-4">
                    {!! $qrCode !!}
                </div>
                <a href="{{ route('admin.tests.qrcode.download', ['id' => $test->id]) }}"
                    class="btn btn-primary">Download QR Code</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html> -->

<?php
//phpinfo();
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code for Test</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container my-auto">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="mb-4">QR Code for Test: {{ $test->name }}</h1>
                <div class="mb-4">
                    {!! $qrCode !!}
                </div>
                <a href="{{ route('admin.tests.qrcode.download', ['id' => $test->id]) }}"
                    class="btn btn-primary">Download QR Code</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>