<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>{{ $subject }}</title>
    <style>
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; }
        .email-header { color: #333; font-size: 24px; margin-bottom: 20px; }
        .email-body { color: #555; line-height: 1.6; }
        .email-action { text-align: center; margin: 20px 0; }
        .email-button { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .email-footer { color: #777; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0;">
    <div class="email-container">
        @if($greeting)
            <h1 class="email-header">{{ $greeting }}</h1>
        @endif
        @foreach($introLines as $line)
            <p class="email-body">{{ is_string($line) ? $line : implode(', ', $line) }}</p>
        @endforeach

        @if($actionText)
            <div class="email-action">
                <a href="{{ $actionUrl }}" class="email-button">{{ $actionText }}</a>
            </div>
        @endif

        @foreach($outroLines as $line)
            <p class="email-body">{{ is_string($line) ? $line : implode(', ', $line) }}</p>
        @endforeach

        <div class="email-footer">
            <p>Jika anda tidak meminta reset kata laluan, sila abaikan e-mel ini.</p>
            <p>&copy; {{ date('Y') }} Nama Syarikat Anda. Semua hak cipta terpelihara.</p>
        </div>
    </div>
</body>
</html>