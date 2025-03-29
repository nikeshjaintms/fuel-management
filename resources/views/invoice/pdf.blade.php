<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>
<body>
    <table border="1" style="width:100%; border-collapse: collapse; font-size: 15px; margin: auto;">
        <tr>

            <th colspan="4" >

               <div style="text-align:left; margin-top:10px; margin-left: 5px" > </div>
                <div><img src="{{ public_path('backend/assets/logo/bill_logo.png') }}" style="width: 50px; height: auto;" alt=""><span  style="font-size:50px;text-align:center;color:rgb(31,73,125)"> DIVYA TRAVELS </span> <span style="text-align: right; justify-content: end; justify-items: end;">Original For Recipient</span></div></th>
        </tr>
        <tr>
            <td style="padding-left: 4px; padding-right: 4px;padding-top: 2px; padding-bottom: 2px;">GSTN : 24BJLPP7379C1ZV</td>
            <td style="padding-left: 4px; padding-right: 4px;padding-top: 2px; padding-bottom: 2px;">STATE : GUJARAT (24)</td>
            <td style="padding-left: 4px; padding-right: 4px;padding-top: 2px; padding-bottom: 2px;">SERVICE CODE : 996601</td>
            <td style="padding-left: 4px; padding-right: 4px;padding-top: 2px; padding-bottom: 2px;">PAN NO : BJLPP7379C</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; padding-left: 2px; padding-right: 2px;font-size:13px">Service Code Description: Rental services of road vehicles including buses, coaches, cars, trucks and other motor vehicles, with</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; padding-left: 2px; padding-right: 2px;font-size:13px" >A 1/1 ArnavBunglows, Nr pramukh park soc, Zadeshwar Bharuch. Mail: divyatravels2010@gmail.com Mo: 9974705458</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">
                TAX INVOICE
            </td>
        </tr>
        <tr>
            <td style="font-weight: bolder;" colspan="2"> Details Of Receiver</td>
            <td style="font-weight: bolder;"> Invoice no</td>
            <td> {{ $invoices->invoice_no ?? "DIVYA/24-25/41" }}</td>
        </tr>
        <tr>
            <td colspan="2"> <span style="font-weight: bolder;">Recipient Name :  {{ $invoices->customer_name }}</span></td>
            <td>Date</td>
            <td> 01/10/2023</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2"><span style="font-weight: bolder;"> Address :-</span>{{$invoices->customer_address}}</td>
            <td>Contract No</td>
            <td> {{ $invoices->contract_no }}</td>
        </tr>
        <tr>

            <td> Contract Date</td>
            <td>{{ $invoices->contract_date }}</td>
        </tr>
        <tr>
            <td colspan="2"><span style="font-weight: bolder;">GSTIN : {{ $invoices->customer_gst }}</span></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4"><span style="font-weight: bolder;">Journey Date : </span> From {{ $invoices->start_date }} To {{ $invoices->end_date  }}</td>
        </tr>
        <tr>
            <td colspan="4"><span style="font-weight: bolder;">Journey route : </span> {{ $invoices->from_point  }}  TO {{ $invoices->to_point }}.</td>
        </tr>
        @foreach($invoice_vehicles as $iv)
        @foreach ($contract_vehicles as $cv)
        @if($iv->vehicle_id == $cv->vehicle_id)


        <tr>
            <td colspan="4"><span style="font-weight: bolder;">Reg.  No of Vehicle :</span> {{ $iv->vehicle_no  }}</td>
        </tr>
        <tr>
            <td><span style="font-weight: bolder;">A.C/NON A.C</span></td>
            <td><span style="font-weight: bolder;">A.C</span></td>
            <td><span style="font-weight: bolder;">RATE</span></td>
            <td><span style="font-weight: bolder;">Amount</span></td>
        </tr>
        <tr>
            <td>Min KM</td>
            <td>{{ $cv->min_km }}</td>
            <td> Rs {{ $cv->rate }}</td>
            <td>
                RS {{ $cv->rate }}
            </td>
        </tr>
        <tr>
            <td>Extra KM</td>
            <td>{{ $iv->extra_km_drive ?? 0.00  }}</td>
            <td> Rs {{ $iv->total_extra_km_amount ?? 0.00 }}</td>
            <td>
                RS {{ $iv->total_extra_km_amount ?? 0.00 }}
            </td>
        </tr>
        <tr>
            <td>Overtime</td>
            <td ></td>
            <td>{{ $cv->rate_per_hour }}

            </td>
            <td>
                RS {{ $iv->overtime_amount ?? 0.00 }}

            </td>
        </tr>
        @endif
        @endforeach
        @endforeach
        <tr>
            <td><span style="font-weight: bolder;">Total KM</span></td>
            <td>{{ $invoices->total_km }}</td>
            <td> </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>Diesel difference</td>
            <td colspan="2">{{ $invoices->start_date }} to {{ $invoices->end_date }}</td>
            <td>

            </td>
        </tr>
        <tr>
            <td></td>
            <td >For 23594 km @Rs</td>
            <td> {{ $invoices->diesel_diff_rate }}</td>
            <td>{{ $invoices->diesel_cost }}</td>
        </tr>

        <tr>
            <td></td>
            <td colspan="2">Amount Before Tax</td>
            <td>
                RS {{ $invoices->grand_subtotal }}
        </tr>
        @if($invoices->tax_type == 'cgst/sgst')
        @php
        $cgst = $invoices->tax_amount / 2;
        $tax = $invoices->tax / 2;
        @endphp
        <tr>
            <td></td>
            <td colspan="2">CGST {{ $tax }}%</td>
            <td>RS {{ $cgst }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">SGST {{ $tax }}%</td>
            <td>RS {{ $cgst }}</td>
        </tr>
        @elseif($invoices->tax_type == 'igst')
        <tr>
            <td></td>
            <td colspan="2">IGST {{ $invoices->tax }}%</td>
            <td>RS {{  $invoices->tax_amount }}</td>
        </tr>
        @endif
        <tr>
            <td></td>
            <td colspan="2">Total Amount After Tax</td>
            <td>
                RS {{ $invoices->total_amount }}
        </tr>
        <tr>
            <td > Amount in Words : - </td>
            <td colspan="3">{{ convertToIndianWords($invoices->total_amount) }}</td>
        </tr>
        <tr>

            <td colspan="4" style="text-align: center;color: rgb(0, 176, 80);">
                For Invoice Related any Quary Call on 90168 88956
            </td>
        </tr>
    </table>

</body>
</html>
