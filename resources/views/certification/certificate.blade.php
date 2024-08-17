<!-- resources/views/certificate.blade.php -->

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
            width: 100%;
            height: 100%;
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
            {{ $name }}
        </div>
        <div class="body">
            This is to certify that <strong>{{ $name }}</strong> has successfully completed the <strong>{{ $course }}</strong> course.
        </div>
        <div class="footer">
            Date: {{ $date }}
        </div>
    </div>
</body>
</html>
