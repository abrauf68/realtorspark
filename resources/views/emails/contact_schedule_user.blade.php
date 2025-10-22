<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Meeting Confirmation - RealtorSpark</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f8f9fa; margin: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        .header { background-color: #0C1817; color: #fff; padding: 20px 30px; }
        .header h1 { margin: 0; font-size: 22px; font-weight: 600; }
        .header span { color: #C6DF41; }
        .content { padding: 30px 35px; font-size: 15px; color: #333; line-height: 1.6; }
        .highlight { color: #C6DF41; font-weight: bold; }
        .footer { background-color: #f1f3f4; padding: 15px; text-align: center; color: #666; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Realtor<span>Spark</span></h1>
        </div>

        <div class="content">
            <p>Dear {{ $contact->name }},</p>

            <p>Your meeting has been successfully <span class="highlight">scheduled</span> with RealtorSpark.</p>

            <p><strong>Date:</strong> {{ $contact->date }}<br>
               <strong>Time:</strong> {{ $contact->time }}</p>

            <p>We look forward to connecting with you!</p>
            <p>— The RealtorSpark Team</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} RealtorSpark. All rights reserved.
        </div>
    </div>
</body>
</html>
