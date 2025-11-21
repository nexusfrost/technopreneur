<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #e6e3dd; /* var(--muted) */
            color: #1A2A57; /* var(--foreground) */
            padding: 40px 0;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #F0EBE2; /* var(--background) */
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #6A8094; /* var(--border) */
        }
        .header {
            background-color: #B83A3F; /* var(--primary) */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .details-box {
            background-color: #ffffff;
            border: 1px solid #6A8094;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .label {
            font-size: 12px;
            color: #2E4980; /* var(--muted-foreground) */
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .value {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        .button {
            display: inline-block;
            background-color: #1A2A57;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #2E4980;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0;">Booking Confirmed!</h1>
        </div>

        <div class="content">
            <p>Hello {{ $reservation->student->name }},</p>
            <p>Your session has been successfully booked. Here are the details:</p>

            <div class="details-box">
                <div class="label">Tutor</div>
                <div class="value">{{ $reservation->tutor->name }}</div>

                <div class="label">Date & Time</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }} <br>
                    {{ \Carbon\Carbon::parse($reservation->start_time)->format('h:i') }} -
                    {{ \Carbon\Carbon::parse($reservation->end_time)->format('h:i') }}
                </div>

                <div class="label">Total Price</div>
                <div class="value" style="color: #B83A3F; font-size: 18px;">
                    ${{ number_format($reservation->price, 2) }}
                </div>
            </div>

            <p>Please remember to complete your down payment via the dashboard to secure your slot.</p>

            <center>
                <a href="{{ route('login') }}" class="button">Go to Dashboard</a>
            </center>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} TutorHub. All rights reserved.
        </div>
    </div>
</body>
</html>
