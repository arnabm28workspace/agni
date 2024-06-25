<!DOCTYPE html>
<html>
<head>
	<title>AGNI - SERVICE SLIP | {{ $service_slip->voucher_no }}</title>
</head>
<body onload="downloadInvoice()">
    <table id="packing_table" style="width: 100%; border-collapse: collapse;" border="1" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table style="width: 100%; height: 140px; border-collapse: collapse;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 20px; border-right: 1px solid #000;">
                            <h3>{{$service_slip->voucher_no}}</h3>
                            <h4>Store Details</h4>
                            @if (!empty($service_slip->store_name))                                
                            Person Name:- {{$service_slip->store_name}}<br/>
                            @endif
                            @if (!empty($service_slip->bussiness_name))                                
                            Comapny Name:- {{$service_slip->bussiness_name}}<br/>
                            @endif
                            @if (!empty($service_slip->contact))                                
                            Contact:- {{$service_slip->contact}}<br/>
                            @endif
                            
                        </td>
                        <td style="padding: 20px;">
                            <h5>Narration:- </h5>
                            <br/>
                            {{-- {{date('d/m/Y', strtotime($data[0]->   created_at))}} --}}
                            {{$service_slip->narration}}
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr style="border-top: 1px solid #000;">
                            <th style="padding: 20px; border-bottom: 1px solid #000; text-align: left;">Date</th>
                            <th style="padding: 20px; border-bottom: 1px solid #000; text-align: left;">Item Name</th>
                            <th style="padding: 20px; border-bottom: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">Price</th>
                        </tr>
                    </thead>
                    <tbody style="height: 400px; vertical-align: top;">
                        @php
                            $total_price = 0;
                        @endphp
                        
                        
                        <tr>
                            <td style="padding: 20px;">{{date('d/m/Y', strtotime($service_slip->entry_date))}}</td>
                            <td style="padding: 20px;">{{$service_slip->item_name}}</td>
                            <td style="padding: 20px; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">{{ number_format((float) $service_slip->amount, 2, '.', '') }}</td>
                            
                        </tr>  
                        
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 1px solid #000;">
                            <td style="padding: 20px;"></td>
                            <td style="padding: 20px;"></td>
                            <td style="padding: 20px; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">{{ number_format((float)  $service_slip->amount, 2, '.', '') }}</td>
                        </tr>
                        <tr style="border-top: 1px solid #000;">
                            <td style="padding: 20px;">{{getAmountAlphabetically($service_slip->amount)}} (in words) </td>
                            
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
    <script>
        function downloadInvoice()
        {
            var print_header = '';
            var divElements = document.getElementById("packing_table").innerHTML;
            var print_footer = '';

            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;
            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                    "<html><head><title></title></head><body><font size='2'>" +
                    divElements + "</font>" + print_footer + "</body>";
            //Print Page
            window.print();
            //Restore orignal HTML
            document.body.innerHTML = oldPage;
            window.close();
            
        }
        
    </script>
</body>
</html>