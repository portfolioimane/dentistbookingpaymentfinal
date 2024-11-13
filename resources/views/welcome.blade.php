<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    

    <title>Your App</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <div id="app"></div> <!-- Vue will mount here -->
    
    <!-- Include your JS files here -->
    <script>
    window.APP_URL = '{{ config('app.url') }}';
    </script>
    <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://www.paypal.com/sdk/js?client-id=client_id&currency=USD"></script>
</body>
</html>
