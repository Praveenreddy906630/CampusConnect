<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Coordinator Account Created</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Hello {{ $name }},</h2>

    <p>Welcome to <strong>CampusConnect</strong>! 🎊</p>

    <p>Your coordinator account has been created successfully. Here are your credentials:</p>

    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>

    <p>You have been assigned to the following event(s):</p>
    <ul>
        @foreach ($eventNames as $event)
            <li>{{ $event }}</li>
        @endforeach
    </ul>

    <p>Please log in to your account and change your password after your first login for security.</p>

    <p>Regards,<br>
    <strong>CampusConnect Admin Team</strong></p>
</body>
</html>
