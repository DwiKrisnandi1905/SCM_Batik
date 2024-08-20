<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
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
            background: radial-gradient(circle, rgba(255, 250, 240, 1) 0%, rgba(245, 245, 245, 1) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        .certificate {
            border: 15px solid #d4af37;
            padding: 50px 80px;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 930px;
            height: 350px;
            text-align: center;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        .certificate::before, .certificate::after {
            content: '';
            position: absolute;
            border: 1px solid #d4af37;
            border-radius: 50%;
            width: 500px;
            height: 500px;
            top: -250px;
            left: -250px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.2) 0%, rgba(255, 250, 240, 0) 70%);
            animation: rotate 15s linear infinite;
        }

        .certificate::after {
            width: 600px;
            height: 600px;
            top: auto;
            bottom: -300px;
            left: auto;
            right: -300px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, rgba(255, 250, 240, 0) 80%);
            animation: rotate-reverse 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes rotate-reverse {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }

        .header {
            font-size: 48px;
            font-weight: bold;
            color: #d4af37;
            margin-bottom: 20px;
            margin-top: -20px;
            font-family: 'Great Vibes', cursive;
        }

        .subheader {
            font-size: 24px;
            color: #6c757d;
            margin-bottom: 10px;
            font-style: italic;
        }

        .recipient {
            font-size: 28px;
            margin: 20px 0;
            font-weight: 700;
            color: #343a40;
        }

        .batik-name {
            font-size: 22px;
            color: #495057;
            margin-bottom: 20px;
            font-weight: 600;
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
            Certificate of Batik Ownership
        </div>
        <div class="subheader">
            In recognition of rightful ownership of batik
        </div>
        <div class="recipient">
            {{ $certificate_number }}
        </div>
        <div class="batik-name">
            {{-- Batik: {{ $batik_name }} --}}
            Batik Mega Mendung
        </div>
        <div class="body">
            Awarded as proof of rightful ownership of batik. Like the intricate designs of batik, your ownership is unique and valuable.
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
