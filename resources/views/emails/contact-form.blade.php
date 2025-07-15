<!DOCTYPE html>
<html>

<head>
    <title>Pesan Baru dari Website</title>
</head>

<body style="font-family: sans-serif; line-height: 1.6;">
    <h2>Anda Menerima Pesan Baru</h2>
    <p>Berikut adalah detail pesan yang dikirim melalui formulir kontak:</p>
    <hr>
    <p><strong>Nama:</strong> {{ $details['name'] }}</p>
    <p><strong>Email:</strong> {{ $details['email'] }}</p>
    <p><strong>Subjek:</strong> {{ $details['subject'] }}</p>
    <p><strong>Pesan:</strong></p>
    <p>{{ $details['message'] }}</p>
    <hr>
    <p><small>Email ini dikirim secara otomatis dari website Anda.</small></p>
</body>

</html>