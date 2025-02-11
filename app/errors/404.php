<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 50px;
        }
        p {
            font-size: 20px;
        }
        .error-details {
            margin-top: 20px;
            text-align: left;
            display: inline-block;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Page Not Found</h1>
    <p>Sorry, the page you are looking for could not be found.</p>
    <div class="error-details">
        <h2>Error Details:</h2>
        <p><strong>URL:</strong> <?php echo $_SERVER['REQUEST_URI']; ?></p>
        <p><strong>Method:</strong> <?php echo $_SERVER['REQUEST_METHOD']; ?></p>
        <p><strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
    </div>
</body>
</html>