<!DOCTYPE html>
<html>
<head>
    <title>Application Accepted</title>
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
        .next-steps {
            background-color: #f0f8ff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
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
        <h1>Housing Application Accepted</h1>
    </div>
    <div class="content">
        <p>Dear {{ $formSubmission->name }},</p>
        <p>We are pleased to inform you that your application for the Rural Housing Scheme has been <strong>ACCEPTED</strong>.</p>
        
        <div class="tracking-id">
            <p>Application Tracking ID: {{ $formSubmission->tracking_id }}</p>
        </div>
        
        <p><strong>Application Details:</strong></p>
        <ul>
            <li>Name: {{ $formSubmission->name }}</li>
            <li>Address: {{ $formSubmission->address }}</li>
            <li>Date Submitted: {{ $formSubmission->created_at->format('F d, Y') }}</li>
            <li>Date Approved: {{ $formSubmission->updated_at->format('F d, Y') }}</li>
        </ul>
        
        <div class="next-steps">
            <h3>Next Steps</h3>
            <p>Our team will contact you within the next 7-10 business days to schedule an appointment. During this appointment, we will:</p>
            <ul>
                <li>Verify your original documents</li>
                <li>Discuss the financial assistance details</li>
                <li>Explain the construction process and timeline</li>
            </ul>
            <p>Please ensure you have all your original documents ready for verification.</p>
        </div>
        
        <p>If you have any questions, please contact our support team at <a href="mailto:support@ruralhousing.gov.in">support@ruralhousing.gov.in</a> or call us at 1800-XXX-XXXX.</p>
        
        <p>Best regards,<br>Rural Housing Scheme Team</p>
    </div>
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html> 