<!DOCTYPE html>
<html>
<head>
	<title>{{ $data[0]->slip_no }}</title>
</head>
<body>
    <h3 align="center">PACKING SLIP</h3>
    <table id="packing_table" style="width: 100%; border-collapse: collapse;" border="1" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table style="width: 100%; height: 140px; border-collapse: collapse;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 20px; border-right: 1px solid #000;">
                            {{$data[0]->bussiness_name}}
                        </td>
                        <td style="padding: 20px;">{{$data[0]->slip_no}}<br/>{{date('d/m/Y', strtotime($data[0]->created_at))}}</td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr style="border-top: 1px solid #000;">
                            <th style="padding: 20px; border-bottom: 1px solid #000; text-align: left;">Descriptions of goods</th>
                            <th style="padding: 20px; border-bottom: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">Ctns</th>
                            {{-- <th style="padding: 20px; border-bottom: 1px solid #000;">Pcs per Ctn</th> --}}
                            <th style="padding: 20px; border-bottom: 1px solid #000;">Total Pieces</th>
                            <th style="padding: 20px; border-bottom: 1px solid #000;">Units</th>
                        </tr>
                    </thead>
                    <tbody style="height: 400px; vertical-align: top;">
                        @php
                            $total_no_ctn = $total_pcs = 0;
                        @endphp
                        @forelse ($data as $item)
                        @php
                            $total_no_ctn += $item->quantity;
                            $total_pcs += $item->pcs;

                            $psProductPcsFromCtn = psProductPcsFromCtn($item->slip_no,$item->product_id);
                            $qty = ($psProductPcsFromCtn * $item->quantity);
                        @endphp
                        <tr>
                            <td style="padding: 20px;">{{$item->pro_name}}</td>
                            <td style="padding: 20px; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">{{$item->quantity}}</td>
                            {{-- <td style="padding: 20px; text-align: center;">
                                {{$psProductPcsFromCtn}}
                                
                            </td> --}}
                            <td style="padding: 20px; text-align: center;">{{$item->pcs}}</td>
                            <td style="padding: 20px; text-align: center;">Pieces</td>
                        </tr>    
                        @empty
                        <tr>
                            <td colspan="5">No items is there</td>                            
                        </tr>    
                        @endforelse                      

                    </tbody>
                    <tfoot>
                        <tr style="border-top: 1px solid #000;">
                            <td style="padding: 20px;">Total No of Ctns</td>
                            <td style="padding: 20px; text-align: center; border-left: 1px solid #000; border-right: 1px solid #000;">{{$total_no_ctn}}</td>
                            <td style="padding: 20px; text-align: center;">{{$total_pcs}}</td>
                            <td style="padding: 20px; text-align: center;"></td>
                            {{-- <td style="padding: 20px; text-align: center;"></td> --}}
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
    <script>
        
    </script>
</body>
</html>