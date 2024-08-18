<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap');

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #fffaf0;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .certificate {
            border: 15px solid #d4af37;
            padding: 150px;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            max-height: 300px;
            text-align: center;
            border-radius: 20px;
        }

        .header {
            font-size: 48px;
            font-weight: bold;
            color: #d4af37;
            margin-bottom: 20px;
            margin-top: -40px;
            font-family: 'Great Vibes', cursive;
        }

        .subheader {
            font-size: 24px;
            color: #6c757d;
            margin-bottom: 40px;
            font-style: italic;
        }

        .recipient {
            font-size: 28px;
            margin: 30px 0;
            font-weight: 700;
            color: #343a40;
        }

        .body {
            font-size: 20px;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .nft {
            font-size: 16px;
            color: #495057;
            word-wrap: break-word;
            background-color: #f8f9fa;
            padding: 10px;
            border: 2px solid #d4af37;
            border-radius: 5px;
            margin-bottom: 30px;
            font-family: 'Courier New', Courier, monospace;
        }

        .footer {
            font-size: 16px;
            margin-top: 40px;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            Certificate of Completion
        </div>
        <div class="subheader">
            In recognition of outstanding achievement
        </div>
        <div class="recipient">
            {{ $certificate_number }}
        </div>
        <div class="body">
            Awarded for your dedication and completion of the program. Like the intricate designs of batik, your journey has been unique and commendable.
        </div>
        <div class="nft">
            {{ $nft_token_id }}
        </div>
        <div class="footer">
            Date: {{ $issue_date }}
        </div>        
    </div>
</body>
</html>
