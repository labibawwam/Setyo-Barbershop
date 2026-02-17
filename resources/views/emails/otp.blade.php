<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kode Verifikasi</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color:#111;">
    <div style="max-width:600px;margin:0 auto;padding:20px;background:#fff;border-radius:8px;">
        <h2 style="margin:0 0 12px 0;color:#111;">Setyo Barbershop</h2>
        <p style="margin:0 0 16px 0;color:#444;">Halo {{ $name ?? 'Pelanggan' }},</p>
        <p style="font-size:20px;margin:0 0 18px 0;">Kode verifikasi Anda:</p>
        <p style="font-size:28px;letter-spacing:4px;font-weight:700;margin:0 0 18px 0;color:#1e3a8a;">{{ $code }}</p>
        <p style="color:#666;font-size:13px;margin:0;">Kode ini akan kadaluarsa dalam 5 menit. Jangan bagikan kode ini kepada siapapun.</p>
        <hr style="margin:18px 0;">
        <p style="color:#999;font-size:12px;margin:0;">Jika Anda tidak meminta kode ini, abaikan email ini.</p>
    </div>
</body>
</html>
