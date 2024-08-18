<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your custom styles here */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            text-align: center;
        }
        .certificate {
            border: 10px solid #797979;
            padding: 50px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
        }
        .recipient {
            font-size: 32px;
            margin: 20px 0;
        }
        .body {
            font-size: 18px;
        }
        .footer {
            font-size: 16px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            Certificate of Completion
        </div>
        <div class="recipient">
            {{ $certificate_number }}
        </div>
        <div class="body">
            This is to certify that has successfully completed the course.
        </div>
        <div class="footer">
            Date: {{ $issue_date }}
        </div>        
    </div>
</body>
</html>
