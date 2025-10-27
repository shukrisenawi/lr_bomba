<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $message->subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px;">
        <h2 style="color: #333;">{{ $message->subject }}</h2>
        @foreach($message->introLines as $line)
            <p style="color: #555; line-height: 1.6;">{{ $line }}</p>
        @endforeach

        @if($message->actionText)
            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ $message->actionUrl }}" style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">{{ $message->actionText }}</a>
            </div>
        @endif

        @foreach($message->outroLines as $line)
            <p style="color: #555; line-height: 1.6;">{{ $line }}</p>
        @endforeach
    </div>
</body>
</html>