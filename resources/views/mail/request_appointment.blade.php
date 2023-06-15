<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <p>Dear {{ $mentor }},</p>
    <p>You have a requested appointment. Please find below the detail of the
        request: </p>
    <h4>Appointment Request Summary</h4>
    <ul>
        <li>
            Mentee: {{ $mentee }}
        </li>
        @if ($opportunity)
            <li>
                Opportunity: {{ $opportunity }}
            </li>
        @endif
        <li>
            Appointment Datetime: {{ $appointment_datetime }}
        </li>
        <li>
            Method: {{ $method }}
        </li>
        <li>
            Status: {{ $status }}
        </li>
        <li>
            Description: {{ $description }}
        </li>
    </ul>
    <p>Please confirm your availability and respond to this email so that we can arrange the meeting</p>
    <p>Sincerely,</p>
    <br />
    <p>Sers Chborng</p>
</body>

</html>
