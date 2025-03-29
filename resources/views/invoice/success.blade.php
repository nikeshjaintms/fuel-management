<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Created</title>
    <script>
        window.onload = function() {
            // Open the invoice in a new tab automatically
            window.open("{{ route('admin.invoice.getInvoiceDetails', ['id' => $id]) }}", "_blank");

            // Redirect back to the invoice list after 2 seconds
            setTimeout(function() {
                window.location.href = "{{ route('admin.invoice.index') }}";
            }, 2000);
        };
    </script>
</head>
<body>
    <h2>Invoice Created Successfully!</h2>
    <p>Your invoice has been opened in a new tab. If it doesn’t open, <a href="{{ route('admin.invoice.getInvoiceDetails', ['id' => $id]) }}" target="_blank">click here</a>.</p>
</body>
</html>
