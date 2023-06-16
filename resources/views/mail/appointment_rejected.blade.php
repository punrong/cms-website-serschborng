<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <p>Dear {{ $mentee }},</p>
    <p>Your appointment has been rejected. Please find the detail below: </p>
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
    <p>Should you have any concern, please feel free to reach out to us at serschborng.info@gmail.com</p>
    <p>Sincerely,</p>
    <br />
    <p>Sers Chborng</p>
</body>

</html>
