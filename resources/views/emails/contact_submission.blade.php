<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Lead Submission - RealtorSpark</title>
    <style>
        body { margin: 0; font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f6f8fa; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
        .header { background-color: #0C1817; color: white; padding: 25px 30px; display: flex; align-items: center; }
        .header img { height: 42px; margin-right: 12px; }
        .header h1 { font-size: 22px; margin: 0; font-weight: 600; }
        .body { padding: 35px 40px; color: #333; background-color: #ffffff; }
        .intro { font-size: 17px; margin-bottom: 25px; line-height: 1.6; }
        .card { background: #f9fafb; border-left: 4px solid #C6DF41; border-radius: 8px; padding: 20px 25px; margin-bottom: 25px; }
        .detail { font-size: 15px; margin: 6px 0; }
        .highlight { color: #0C1817; font-weight: bold; }
        .button { display: inline-block; background-color: #C6DF41; color: #0C1817; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; margin-top: 15px; }
        .footer { background-color: #f0f2f3; padding: 20px 30px; text-align: center; color: #666; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{-- <img src="{{ asset('images/fb-logo.png') }}" alt="RealtorSpark Logo"> --}}
            <h1>Realtor<span style="color:#C6DF41;">Spark</span></h1>
        </div>

        <div class="body">
            <p class="intro">
                <strong>Great news!</strong> You’ve received a new contact form submission through your RealtorSpark platform.
            </p>

            <div class="card">
                <p class="detail"><strong>Name:</strong> {{ $contact->name }}</p>
                <p class="detail"><strong>Email:</strong> {{ $contact->email }}</p>
                <p class="detail"><strong>Phone:</strong> {{ $contact->phone }}</p>
                @if($contact->company_name)
                    <p class="detail"><strong>Company:</strong> {{ $contact->company_name }}</p>
                @endif
            </div>

            <p>To view or manage this lead, log in to your <span class="highlight">RealtorSpark</span> admin dashboard.</p>
            <a href="{{ route('dashboard') }}" class="button">View in Dashboard</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} RealtorSpark — All rights reserved.
        </div>
    </div>
</body>
</html>
