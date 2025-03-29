<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Filling Report</title>
    <style>
        /* Page Border (Optional) */
        @page {
            margin: 20px;
        }

        /* Table Styling */
        body {
            font-family: Arial, sans-serif;
        }

        .report-container {
            width: 100%;
            text-align: center;
        }

        table {
            width: 95%;
            margin: 10px auto; /* Center the table */
            border-collapse: collapse;
            border: 1px solid black;
        }

        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="report-container">
        <h2>Fuel Filling Report</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vehicle</th>
                    <th>Driver</th>
                    <th>Customer</th>
                    <th>Filling Date</th>
                    <th>Nozzle No</th>
                    <th>Quantity</th>
                    <th>Kms</th>
                    <th>AVG (Fuel Consumption)</th>
                    <th>AVG by Company</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->vehicle_no }}</td>
                    <td>{{ $item->driver_name }}</td>
                    <td>{{ $item->customer_name }}</td>
                    <td>{{ $item->filling_date }}</td>
                    <td>{{ $item->nozzle_no }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                    <td>{{ number_format($item->kilometers, 2) }}</td>
                    <td>{{ number_format($item->average_fuel_consumption, 2) }}</td>
                    <td>{{ $item->average }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
