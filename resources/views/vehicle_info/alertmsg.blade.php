<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle infomation </title>
</head>
<body>
    <h1>Renew</h1>

    @if (!empty($alerts))
        <script>
            window.onload = function() {
                let alerts = @json($alerts); // Convert PHP array to JavaScript array
                alerts.forEach(function(alert) {
                    alert(alert); // Show an alert popup for each task reminder
                });
            };
        </script>
    @endif
</body>
</html>
