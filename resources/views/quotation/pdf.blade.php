<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quotation</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,900;1,1000&display=swap" rel="stylesheet">
        <style>
        .roboto{
        font-family: "Roboto", sans-serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "wdth" 100;
        }
        /* Watermark Style */

            /* Watermark */
            body::before {
                content: "CONFIDENTIAL";
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-30deg);
                font-size: 80px;
                color: rgba(0, 0, 0, 0.1);
                font-weight: 700;
                z-index: -1;
                white-space: nowrap;
            }
    </style>
    </head>
    <body>
        <h1 class="roboto" style="color: #00B0F0;font-weight: 900;"><center>DIVYA TRAVELS</center></h1>
        <p>Passenger vehicle like Luxury-Buses, Mini-Bus, Tempo-traveler (A.C.),
            Winger etc. available for hire
            Daily/monthly or annum Basis.</p>
        <p>FF 14, Abhinav avenue, Zadeshwar Chokdi, Bharuch.</p>
        <hr>
        <div style="display: flex;justify-content: space-between;">
            <span>MO: -9974705458</span>
            <span style="float: right;">Mail: divyatravels2010@gmail.com</span>
        </div>
        <hr>

            <p style="display: flex; justify-content: end;float:right;">Date:
               {{ $data->quotation_date}}</p>
                <br>
        <p style="display: flex;text-align:center;">QUOTATION</p>
        <br>
        <br>
        <span>Respected Sir/Ma'am,</span>
        <p>{{ $data->customer_name }}</p>
        <p>{{  $data->customer_address }}</p>
        <p>I proprietor of DIVYA TRAVELS submit quotation from Bharuch to
            company as per requirement.</p>

        <table
            style="border: 2px solid black; border-collapse: collapse;align-items: center; justify-self: center;">
            <tr>
                <td
                    style="border: 2px solid black;width: fit-content; padding: 4px; text-align: center;">No.</td>
                <td
                    style="border: 2px solid black;width: fit-content; padding: 4px; text-align: center;">Type
                    of Vehicle</td>
                <td
                    style="border: 2px solid black;width: fit-content; padding: 4px; text-align: center;">KM</td>
                <td
                    style="border: 2px solid black;width: fit-content; padding: 4px; text-align: center;">Rate</td>
                <td
                    style="border: 2px solid black;width: fit-content; padding: 4px; text-align: center;">Extra
                    Km (Rs/Km)</td>
                <td
                    style="border: 2px solid black;width: fit-content; padding: 4px; text-align: center;">Over
                    Time (Rs/hour)</td>
                <td
                    style="border: 2px solid black;width: fit-content; padding: 4px; text-align: center;">Average(Km/Ltr)</td>
            </tr>
            @php
            $i = 1
            @endphp
            @foreach($quotation_items as $qi)
            <tr>
                <td style="border: 2px solid black;padding: 4px; text-align: center;">{{ $i++ }}</td>
                <td style="border: 2px solid black;padding: 4px; text-align: center;">{{ $qi->type_of_vehicle }}</td>
                <td style="border: 2px solid black;padding: 4px; text-align: center;">{{ $qi->km }}</td>
                <td style="border: 2px solid black;padding: 4px; text-align: center;">{{ $qi->rate }}</td>
                <td style="border: 2px solid black;padding: 4px; text-align: center;">{{ $qi->extra_km_rate }}</td>
                <td style="border: 2px solid black;padding: 4px; text-align: center;">{{ $qi->over_time_rate }}</td>
                <td style="border: 2px solid black;padding: 4px; text-align: center;">{{ $qi->average }}</td>
            </tr>
            @endforeach
        </table>
        <p><strong>Note:</strong></p>
        <ul>
            <li>GST will be Charged extra @ 12 % if applicable.</li>
            <li>We will claim Diesel Difference if Diesel price hike during
                contract Period on Variation of Rs.1.00/-
                . Present Fuel rate Rs. 90.49</li>
            <li>Payment as per company rules.</li>
        </ul>

        <p>For <br>
            DIVYA TRAVELS / SWAMI VIVEKANAD TOURISOM
            <br>
            MR. DIPESH O PANCAHL</p>

    </body>
</html>
