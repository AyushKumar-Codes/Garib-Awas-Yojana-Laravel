<!DOCTYPE html>
<html>
<head>
    <title>Application Submitted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            border: 1px solid #ddd;
            border-top: none;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .tracking-id {
            background-color: #f9f9f9;
            padding: 10px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Housing Application Submitted</h1>
    </div>
    <div class="content">
        <p>Dear {{ $formSubmission->name }},</p>
        <p>Thank you for submitting your application for the Rural Housing Scheme. Your application has been received and is now being processed.</p>
        
        <p><strong>Application Details:</strong></p>
        <ul>
            <li>Name: {{ $formSubmission->name }}</li>
            <li>Address: {{ $formSubmission->address }}</li>
            <li>Aadhar Number: {{ substr($formSubmission->aadhar_number, 0, 4) }}XXXX{{ substr($formSubmission->aadhar_number, -4) }}</li>
            <li>Date Submitted: {{ $formSubmission->created_at->format('F d, Y') }}</li>
        </ul>
        
        <div class="tracking-id">
            <p>Your Application Tracking ID: {{ $formSubmission->tracking_id }}</p>
            <p>Please keep this tracking ID for future reference. You can use it to check the status of your application on our website.</p>
        </div>
        
        <p>We will review your application as soon as possible and notify you when there's an update.</p>
        
        <p>Best regards,<br>Rural Housing Scheme Team</p>
    </div>
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html> 