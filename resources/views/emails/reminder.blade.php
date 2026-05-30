<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }

        .reminder-badge {
            display: inline-block;
            background-color: #ffc107;
            color: #333;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .detail-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }

        .detail-item {
            margin: 10px 0;
        }

        .detail-label {
            font-weight: 600;
            color: #667eea;
            display: inline-block;
            width: 100px;
        }

        .detail-value {
            color: #333;
        }

        .button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: 600;
        }

        .button:hover {
            background-color: #764ba2;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            margin-top: 30px;
        }

        .emoji {
            font-size: 24px;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><span class="emoji">⏰</span>Reminder Pekerjaan</h1>
        </div>

        <div class="content">
            <div class="reminder-badge">
                {{ $reminderType }}
            </div>

            <p>Halo <strong>{{ $user->name }}</strong>,</p>

            @if ($type === '1_day')
            <p>📅 Pekerjaan Anda <strong>besok</strong> akan dimulai!</p>
            @elseif ($type === '1_hour')
            <p>⏱️ Pekerjaan Anda akan dimulai <strong>dalam 1 jam</strong>!</p>
            @elseif ($type === 'on_day')
            <p>🚀 Pekerjaan Anda <strong>hari ini</strong> dimulai!</p>
            @endif

            <div class="detail-box">
                <div class="detail-item">
                    <span class="detail-label">📋 Pekerjaan:</span>
                    <span class="detail-value">{{ $pekerjaan->nama_pekerjaan }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">📅 Tanggal:</span>
                    <span class="detail-value">{{ $pekerjaan->tanggal->format('l, d MMMM Y') }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">⏰ Waktu:</span>
                    <span class="detail-value">08:00 - 17:00 (Asia/Jakarta)</span>
                </div>

                @if ($pekerjaan->client)
                <div class="detail-item">
                    <span class="detail-label">👤 Client:</span>
                    <span class="detail-value">{{ $pekerjaan->client->nama_client }}</span>
                </div>
                @endif

                @if ($pekerjaan->lokasi)
                <div class="detail-item">
                    <span class="detail-label">📍 Lokasi:</span>
                    <span class="detail-value">{{ $pekerjaan->lokasi->nama_lokasi }}</span>
                </div>
                @endif
            </div>

            <p>✅ Pastikan Anda sudah siap dengan semua kebutuhan untuk pekerjaan ini.</p>

            <a href="{{ route('pekerjaan.show', $pekerjaan->id) }}" class="button">
                👉 Lihat Detail Pekerjaan
            </a>

            <div class="footer">
                <p>
                    Reminder ini dikirim otomatis dari Sistem Informasi Tim Lapangan.<br>
                    Jika Anda menganggap ini adalah kesalahan, abaikan email ini.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
