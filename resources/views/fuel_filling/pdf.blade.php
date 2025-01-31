<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fuel Filling</title>
</head>
<body>
    <h2> </h2>
        @if($data->isEmpty())
        <p>Nothing to show</p>

        @else
        <table style="border-collapse: collapse; width: 100%;">
            <tr>
                <th>ID</th>
                <th>Vehicle</th>
                <th>Driver</th>
                <th>Customer</th>
                <th>Filling Date</th>
                <th>Quantity</th>
                <th>Kilometers</th>
                <th>Average (Fuel Consupmation)</th>
                <th>Average(Claim by Company)</th>
            </tr>


            @foreach($data as $item)
                <tr>
                    <td>{{$item->id }}</td>
                    <td>{{$item->vehicle_no }}</td>
                    <td>{{$item->driver_name }}</td>
                    <td>{{$item->customer_name }}</td>
                    <td>{{$item->filling_date }}</td>
                    <td>{{$item->quantity }}</td>
                    <td>{{$item->kilometers }}</td>
                    <td>{{$item->average_fuel_consumption }}</td>
                    <td>{{$item->average }}</td>
                    <>
                </tr>
            @endforeach


        </tr>
    </table>
@endif

</body>
</html>
