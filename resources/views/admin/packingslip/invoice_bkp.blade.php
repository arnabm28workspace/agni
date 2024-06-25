<!DOCTYPE html>
<html>
<head>
	<title>AGNI SALES INVOICE {{ $invoice->invoice_no }}</title>
</head>
<body onload="downloadInvoice()">
	<table border="1" style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0" id="invoice_table">
		<tr>
			<td>
				<table border="1" style="width: 100%; border-collapse: collapse;" cellpadding="10" cellspacing="0">
					<tr>
						<td rowspan="2">
							<p style="margin: 0">Sender</p>
							<p style="margin: 0;"><strong>{{$invoice->staff_name}}</strong><br/>
                                {{$invoice->staff_address}}
                            </p>
							<p style="margin: 0;">Ph No: {{$invoice->staff_mobile}}</p>
						</td>
						<td>
							<p style="margin: 0;">Invoice Code:<br/><strong>{{$invoice->invoice_no}}</strong></p>
						</td>
						<td>
							<p style="margin: 0;">Invoice Date:<br/><strong>{{ date('d-M-Y',strtotime($invoice->created_at)) }}</strong></p>
						</td>
					</tr>
					<tr>
						<td align="center">
							<p style="margin: 0;">Order No: {{$invoice->order_no}}</p>
							<p style="margin: 0;">Order Date: {{ date('d-M-Y',strtotime($invoice->ordered_at)) }}</p>
						</td>
						<td>
							<p style="margin: 0;">Portal: <strong>AGNI INVENTORY</strong></p>
							<p style="margin: 0;">Payment Mode</p>
							<p style="margin: 0;"><strong>PREPAID</strong></p>
						</td>
					</tr>
					<tr>
						<td>
							<p style="margin: 0;">Bill To: <br/>
								<strong>{{$invoice->store_name}}</strong>
								<br/>
                            	{{$invoice->store_billing_address}}
                            </p>
							<p style="margin: 0;">T : {{$invoice->store_whatsapp}}</p>
						</td>
						<td>
							<p style="margin: 0;">Ship To: <br/>
								<strong>{{$invoice->store_name}}</strong>
								<br/>
                            	{{$invoice->store_shipping_address}}
                            </p>
							<p style="margin: 0;">T : {{$invoice->store_whatsapp}}</p>
						</td>
						<td>
                            <p style="margin: 0;">Slip No: <br/><strong>{{$invoice->slip_no}}</strong> </p>
							{{-- <p style="margin: 0;">Dispatch Through<br/><strong>EK</strong><br/>AWB No<br/> MYNP0032032743</p> --}}
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border="1" style="width: 100%; border-collapse: collapse;" cellpadding="10" cellspacing="0">
					<tr>
						<th align="center">Sl No.</th>
						<th align="center">Descriptions of Goods</th>
						<th align="center">HSN Code</th>
						<th align="center">Pcs</th>
						<th align="center">Price per Pieces</th>
						<th align="center">Total Price</th>
					</tr>
                    @php
                        $i=1;
                        $sum_count = 0;
						$sum_org_price = 0;
                        $sum_total_price = 0;
                    @endphp
                    @forelse ($invoice->invoice_products as $items)                       
                    

                    @php
                        $sum_count += $items->quantity;
						$sum_org_price += $items->price;
						$sum_total_price += $items->count_price;
                    @endphp
					<tr>
						<td align="center">{{$i}}</td>
						<td><strong>{{$items->pro_name}}</strong></td>
						<td align="center">{{$items->hsn_code}}</td>
						<td align="center">{{$items->quantity}}</td>					
						<td align="right">{{ $items->price }}</td>
						<td align="right">{{ $items->count_price }}</td>	
					</tr>
                    
                    @php
                        $i++;
                    @endphp
                    @empty
                    <tr>
                        <td colspan="6">No items available</td>
                    </tr>    
                    @endforelse
					
					<tr>
						<td align="center"></td>
						<td><strong>Total</strong></td>
						<td align="center"></td>
						<td align="center">{{$sum_count}}</td>
						<td align="right">{{$sum_org_price}}</td>
						<td align="right">{{$sum_total_price}}</td>
					</tr>	
					<tr>
						
						<th align="center" colspan="3">Tax</th>
						
						<th align="center"></th>
						<th align="center"></th>
						<th align="center"></th>
					</tr>					
					<tr>
						<td align="center"></td>
						<td><strong>SGST</strong></td>
						<td align="center">{{$invoice->sgst_percentage}} %</td>
						<td align="center"></td>
						<td align="right"></td>
						<td align="right"></td>
					</tr>					
					<tr>
						@php
							
						@endphp
						<td align="center"></td>
						<td><strong>CGST</strong></td>
						<td align="center">{{$invoice->cgst_percentage}} %</td>
						<td align="center"></td>
						<td align="right"></td>
						<td align="right"></td>
					</tr>	
					<tr>
						<td align="center"></td>
						<td><strong>Grand Total</strong></td>
						<td align="center">{{ ($invoice->sgst_percentage + $invoice->cgst_percentage) }} %</td>
						<td align="center"></td>
						<td align="right"></td>
						<td align="right">{{ $invoice->net_price }}</td>
					</tr>			
				</table>
			</td>			
		</tr>
		<tr>
			<td>
				<table border="0" style="width: 100%; border-collapse: collapse;" cellpadding="10" cellspacing="0">
					<tr>
						<td valign="top">
							<p style="margin: 0;">Amount Chargeable (in words)<br/><strong>INR {{getAmountAlphabetically($invoice->net_price)}}</strong></p>
						</td>
						<td align="right" valign="top"><h4 style="margin: 0;">E. & O.E</h4></td>
					</tr>
					<tr>
						<td style="width: 50%;">
							<p style="margin: 0;"><u>Declaration</u></p>
							<p style="margin: 0;">1. All claims, if any, for shortages or damages must be reported to customer service on the day of delivery through the contact us page on the web store 2. All Disputes are subject to Maharashtra (27) jurisdiction only.</p>
						</td>
						<td align="center" style="width: 50%; border-top: 1px solid #000; border-left: 1px solid #000;">
							<h3>AGNI International</h3>
							<h3>Authorised Signatory</h3>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border="0" style="width: 100%; border-collapse: collapse;" cellpadding="10" cellspacing="0">
					<tr>
						<td style="width: 49%;"><p style="margin: 0;"><strong>Bill By</strong></td>
						<td style="width: 2%;" align="center">:</td>
						<td style="width: 49%;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    <script>
        function downloadInvoice()
        {
            var print_header = '';
            var divElements = document.getElementById("invoice_table").innerHTML;
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