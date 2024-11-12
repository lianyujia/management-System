<!-- csrf_error.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid CSRF Token</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        .container { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; }
        .container h1 { color: #e74c3c; }
        .btn { background-color: #3498db; color: #fff; padding: 10px 20px; border: none; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Invalid CSRF Token</h1>
        <p>Your session may have expired, or there was an issue with the request. Please log in again.</p>
        <a href="index1.php" class="btn">Return to Login</a>
    </div>
</body>
</html>
