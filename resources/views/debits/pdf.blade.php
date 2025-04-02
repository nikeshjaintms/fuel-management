<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debit Note {{ $debits->credit_number }}</title>
    <style>
h4 {
    text-align: center;
    align-items: center;
    justify-content: center;

}

table {
    border-collapse: collapse;
    width: 80%;
    max-width: 800px;
}

th, td {
    padding: 4px;
    border: 1px solid black;
    text-align: start;
}

@media print {
    body {
        justify-content: start;
        align-items: start;
        width:fit-content;
    }
    table {
        width:fit-content;
        max-width: 100%;
        padding: 4px
    }
}
    </style>
</head>
<body >
    <h4><center>Debit Note</center></h4>
    <table  border="0" style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid black;" rowspan="4" colspan="6">
                <strong>DIVYA TRAVELS</strong><br>
                A-1/1 ARNAV BUNGLOW,<br>
                NEAR PRAMUKH PARK<br>
                ZADESHWAR<br>
                BHARUCH<br>
                GSTIN/UIN: 24BJLPP7379C1ZV<br>
                State Name: Gujarat, Code: 24<br>
                E-Mail: divyatravels2010@gmail.com</td>
            <td style="border: 1px solid black;">Debit Note No. <strong>{{ $debits->debit_number }}</strong></td>
            <td style="border: 1px solid black;width:150px;">Date: <strong>{{ $debits->debit_date }}</strong></td>

        </tr>
        <tr>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;">Mode/Terms of Payment</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">Buyer's Ref. <br>
               <strong> {{ $debits->invoice_no }}<br> DATE  {{ $debits->invoice_date }} </strong></td>
            <td style="border: 1px solid black;">Other Reference(s)
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">Buyer's Order No.</td>
            <td style="border: 1px solid black;"></td>
        </tr>
        <tr>
            <td style="border: 1px solid black;" rowspan="3" colspan="6">
               <strong> Party:
                {{ $debits->customer_name }}</strong>
                <br>
                Address:
                {{ $debits->customer_address }}
                <br>
                GSTIN:
                {{ $debits->customer_gst }}
            </td>
            <th style="border: 1px solid black;">Despatch Document No.</th>
            <th style="border: 1px solid black;">Destination</th>
        </tr>
        <tr>
            <th style="border: 1px solid black;">Despatched through
            </th>
            <th style="border: 1px solid black;"></th>
        </tr>
        <tr>
            <th style="border: 1px solid black;">Terrms of Delivery</th>
            <th style="border: 1px solid black;"></th>
        </tr>
    </table>
    <table  border="0" style="width:100%; border-collapse: collapse;">
        <tr style="border: 1px solid black;">
            <th style="border: 1px solid black;">SR No</th>
            <th style="border: 1px solid black;" width="262px" >Particulars</th>
            <th style="border: 1px solid black;">HSN/SAC</th>
            <th style="border: 1px solid black;">Quantity</th>
            <th style="border: 1px solid black;">Rate</th>
            <th style="border: 1px solid black; width: 83px;">Unit</th>
            <th style="border: 1px solid black;">Amount</th>
        </tr>
        @php
        $i = 1;
        @endphp
        @foreach($debits_items as $di)
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;">{{ $i++ }}</td>
            <td style="border: 1px solid black;" >{{ $di->item }}</td>
            <td style="border: 1px solid black;">{{ $di->hsn_sac }}</td>
            <td style="border: 1px solid black;">{{ $di->quantity }}</td>
            <td style="border: 1px solid black;">{{ $di->rate }}</td>
            <td style="border: 1px solid black;">{{ $di->unit }}</td>
            <td style="border: 1px solid black;">{{ $di->amount }}</td>
        </tr>
        @endforeach
    </table>
    <table  border="1" style="width:100%; border-collapse: collapse;">
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;text-align: right;width: 215px" colspan="6"><strong>Subtotal Amount</strong></td>

            <td style="border: 1px solid black;" colspan="2">{{ $debits->subtotal_amount }}</td>
        </tr>
        @php
        $cgst = $debits->tax_amount / 2;
        $tax = $debits->tax / 2;

        @endphp
        @if($debits->tax_type == 'cgst/sgst')
        <tr style="border: 1px solid black;">
            <th style="border: 1px solid black;text-align: right;" colspan="6">CGST {{$tax}}% Rs</th>

            <td style="border: 1px solid black;" colspan="2">{{ $cgst }}</td>
        </tr>
        <tr style="border: 1px solid black;">
            <th style="border: 1px solid black;text-align: right;" colspan="6">SGST {{$tax}}% Rs</th>

            <td style="border: 1px solid black;" colspan="2">{{ $cgst }}</td>
        </tr>
        @elseif($debits->tax_type == 'igst')
        <tr style="border: 1px solid black;">
            <th style="border: 1px solid black;text-align: right;" colspan="6">IGST {{$debits->tax}}% Rs</th>

            <td style="border: 1px solid black;" colspan="2">{{ $debits->tax_amount }}</td>
        </tr>
        @endif
        <tr style="border: 1px solid black;">
            <th style="border: 1px solid black;text-align: right;" colspan="6">Total Rs</th>
            <td style="border: 1px solid black;"colspan="2">{{ $debits->total_amount }}</td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;"colspan="8" >Amount in Words: {{ convertToIndianWords($debits->total_amount) }}</td>
        </tr>
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;" colspan="8"> <strong>Note: Rate Difference calcuation mistake in bill so issue debit note</strong></td>
        </tr>
    </table>
</body>
</html>
