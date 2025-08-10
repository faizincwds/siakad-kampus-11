<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akses Ditolak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #636b6f;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8fafc;
        }

        .container {
            text-align: center;
        }

        .title {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .info {
            font-size: 14px;
            color: #b0bec5;
        }

        a {
            color: #3490dc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">403 | Akses Ditolak</div>
        <div class="message">Anda tidak memiliki izin untuk mengakses halaman ini.</div>
        <div class="info">Anda akan diarahkan kembali dalam <strong>6 detik</strong>.</div>
        <div class="info"><a href="#" onclick="window.history.back()">Klik di sini jika tidak otomatis kembali.</a></div>
    </div>

    <script>
        setTimeout(function () {
            window.history.back();
        }, 6000);
    </script>
</body>
</html>
