@extends('admin.layouts.app')
@section('page', 'Get Cartons')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Sales</li>
        <li>#{{$order_no}}</li>
        <li>Generate Packing Slip</li>
        <li>Get Cartons</li>
    </ul>
    
    <h5>Product:- <strong>{{$product_name}}</strong></h5>
    <h5>Required Quantity:- <strong>{{$ctns}} ctns ({{$pcs}} pcs)</strong></h5>
    <h5>Final Quantity:- <strong id="pcs_set"></strong></h5>
    <div class="row">
        <div class="col-sm-12">  
            @if($errors->any())                      
                {!! implode('', $errors->all('<p class="small text-danger">:message</p>')) !!}
            @endif
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <form action="{{ route('admin.packingslip.set_product_ctns_pcs_ps') }}" method="POST">
            @csrf
            <input type="hidden" name="" id="total_pcs">
            <input type="hidden" name="order_id" value="{{$order_id}}">
            <input type="hidden" name="product_id" value="{{$product_id}}">
            <table class="table">
                <thead>
                    <tr>
                        <th class="check-column"> </th>                   
                        <th>Ctn</th>   
                        <th>Pcs</th>
                        <th>Weight</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $settle_pcs_value = $pcs;
                    @endphp                    
                    @forelse ($data as $item) 
                    @php
                        $checked = "";
                        if(in_array($item->barcode_no,$barcode_no_arr)){
                            $checked = "checked";
                        }
                    @endphp
                    <tr>
                        <td class="check-column">
                            <div class="form-check">
                                <input name="barcode_no[]"  class="form-check-input data-check" type="checkbox" value="{{$item->barcode_no}}"  data-pcs="{{$item->pcs}}" id="checkbox{{$item->barcode_no}}" {{$checked}}>
                            </div>                            
                        </td>
                                                
                        <td width="10%">
                            <span title="{{$item->barcode_no}}">
                                {!! $item->code_html !!}
                                <span style="width: 100%; display: block; text-align: center; color: #000000;">{{$item->barcode_no}}</span>
                            </span>                                   
                        </td>
                        <td>
                            {{$item->pcs}} pieces
                        </td>    
                        <td>
                            <span id="scannedweight{{$item->barcode_no}}">{{$item->stock_in_weight_val / 1000}} kg</span>
                        </td>                   
                    </tr>                    
                   
                    @empty
                    <tr>
                        <td colspan="4">
                            <span>No stock available on this product</span>
                        </td>
                    </tr>
                    @endforelse
                <tbody>
            </table> 
            <div class="form-group">
                <a href="{{ route('admin.packingslip.add', $order_id) }}" class="btn btn-sm btn-danger">Back</a>
                <button id="submitBtn" type="submit" class="btn btn-sm btn-success">Pick Cartons</button>
            </div>
            </form>
        </div>
    </div>
    
</section>
@endsection

@section('script')
    <script>
        var totalPcs = '';
        var reqPcs = '{{$pcs}}';
        
        $(document).ready(function(){
            var totalPrevCtn = "{{ count($barcode_no_arr) }}";
            var totalPrevPcs = "{{$total_pcs}}";
            // alert(totalPrev);
            var total_ctns = 0;
            totalPcs = totalPrevPcs;
            total_ctns = totalPrevCtn;

            $('#total_pcs').val(totalPcs);
            $('#pcs_set').text(total_ctns+' ctns ( '+totalPrevPcs+' pcs ) ');
            if(totalPcs == reqPcs){
                // alert('Full');
                $("input:checkbox.data-check:not(:checked)").attr('disabled',true);
            }
            
            $('.data-check').change(function () {
                var barcode = this.value;
                var isChecked = $('input:checkbox#checkbox'+barcode+':checked').length;
                var pcs = $("#checkbox"+barcode).data('pcs');
            
                if(isChecked == 1){
                    // totalPcs += pcs;
                    $('input:checkbox.data-check:checked').each(function(){
                        
                        totalPcs += $(this).attr("data-pcs")
                        
                    });
                } 

                alert(totalPcs)

                if (isChecked == 0) {                
                    var total_pcs = (totalPcs - pcs);
                    totalPcs = total_pcs;
                    $("input:checkbox.data-check:not(:checked)").attr('disabled',false);
                }
                if(totalPcs > reqPcs){
                    alert('Required pcs exceeded! You have added '+(totalPcs - reqPcs)+' pcs');
                    $("input:checkbox.data-check:not(:checked)").attr('disabled',true);
                }

                if(totalPcs == reqPcs){
                    // alert('Full');
                    $("input:checkbox.data-check:not(:checked)").attr('disabled',true);
                }
                total_ctns = $('input:checkbox.data-check:checked').length;
                $('#total_pcs').val(totalPcs);
                $('#pcs_set').text(total_ctns+' ctns ( '+totalPcs+' pcs ) ');
                
            })
        })

        

    </script>
@endsection
