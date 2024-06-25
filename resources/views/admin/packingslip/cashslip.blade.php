
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="format-detection" content="date=no" />
	<meta name="format-detection" content="address=no" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="x-apple-disable-message-reformatting" />
	<title>{{$invoice->invoice_no}}</title>
</head>

<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#f9f9f9; -webkit-text-size-adjust:none; font-family: Arial, Helvetica, sans-serif;">
	<table id="packing_table" style="width:700px; margin: 0 auto;" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td style="font-size: 20px; font-weight: bolder; padding: 40px 0 20px; border-bottom: 1px solid #000; text-transform: uppercase;" align="center" valign="top">
				Rough Estimate
			</td>
		</tr>
		<tr>
			<td width="100%">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" style="font-size: 14px; font-weight: bold; padding: 10px; border-bottom: 1px solid #000;" width="70%">
                            {{$invoice->bussiness_name}}
                        </td>
						<td style="font-size: 14px; font-weight: normal; padding: 10px; border-left: 1px solid #000; border-bottom: 1px solid #000;" width="70%">{{$invoice->invoice_no}} <br> <br> {{ date('d/m/Y',strtotime($invoice->ordered_at)) }}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top" style="height: 350px; border-bottom: 1px solid #000;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<th style="font-size: 14px; padding:10px; border-bottom: 1px solid #000;" align="left">Description of goods</th>
						<th style="font-size: 14px; padding:10px; border-bottom: 1px solid #000;" align="center">Quantity (pcs)</th>
						<th style="font-size: 14px; padding:10px; border-bottom: 1px solid #000;" align="center">Rate</th>
						<th style="font-size: 14px; padding:10px; border-bottom: 1px solid #000;" align="right">Amount</th>
					</tr>
                    @php
                        $total_amount = 0;
                    @endphp
                    @foreach ( $invoice->invoice_products as $items )
                    @php
                        $total_amount += $items->total_price; 
                    @endphp
                    <tr>
						<td style="font-size: 14px; font-weight: normal; color:#222; padding: 10px; border-bottom: 1px solid #eee;" align="left">{{$items->pro_name}}</td>
						<td style="font-size: 14px; font-weight: normal; color:#222; padding: 10px; border-bottom: 1px solid #eee;" align="center">{{$items->pcs}}</td>
						<td style="font-size: 14px; font-weight: normal; color:#222; padding: 10px; border-bottom: 1px solid #eee;" align="center">Rs. {{ number_format((float)$items->single_product_price, 2, '.', '') }}</td>
						<td style="font-size: 14px; font-weight: normal; color:#222; padding: 10px; border-bottom: 1px solid #eee;" align="right">Rs. {{ number_format((float)$items->total_price, 2, '.', '') }}</td>
					</tr>             
                    @endforeach										
				</table>
			</td>
		</tr>

		<tr>
			<td width="100%" valign="top" >
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="70%" style="text-transform: uppercase; padding: 10px 0; border-bottom: 1px solid #000; font-size: 14px;" align="right">Item Value</td>
						<td width="30%" style="padding: 10px 0; border-bottom: 1px solid #000; font-size: 14px;" align="right">Rs. {{ number_format((float)$total_amount, 2, '.', '') }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    <script>
       
    </script>
</body>
</html>