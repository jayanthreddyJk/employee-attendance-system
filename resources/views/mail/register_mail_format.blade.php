<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Mail</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>

    <p>Dear {{ $mailData['name'] }},</p>

    <p>Congratulations!</p>

    <p>We are delighted to inform you that your registration has been successfully completed.</p>

    <p>Here are your login credentials:</p>
    <ul>
        <li><strong>User ID:</strong> {{ $mailData['email'] }}</li>
        <li><strong>Password:</strong> {{ $mailData['password'] }}</li>
    </ul>

    <p>Please keep your login credentials confidential and do not share them with others.</p>

    <p>Thank you for your patience!</p>

    <p>Best regards,<br>
    The Ardhas Technology Team</p>

</body>
</html>
