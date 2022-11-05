<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 50%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .card-header {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Verification Code</div>
            <div class="card-body">
                Please submit your verification code: {{$code}}
            </div>
            <div class="card-footer">
                Welcome,
                {{$appName}}
            </div>
        </div>
    </div>
</body>
</html>
