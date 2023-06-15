<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <p>Dear {{ $mentee }},</p>
    <p>Thank you for reaching out to us! Your appointment has been requested. Please find below the detail of your
        request: </p>
    <h4>Appointment Request Summary</h4>
    <ul>
        <li>
            Mentor: {{ $mentor }}
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
    <p>Sincerely,</p>
    <br />
    <p>Sers Chborng</p>
</body>

</html>
