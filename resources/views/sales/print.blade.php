<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $sale->invoice_no }}</title>
</head>

<body>
    <h1>Invoice {{ $sale->invoice_no }}</h1>
    <p>Status: {{ $sale->status }}</p>
</body>

</html>
