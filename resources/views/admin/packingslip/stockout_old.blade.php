@extends('admin.layouts.app')
@section('page', 'Stock Out')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Sales</li>
        <li><a href="{{ route('admin.packingslip.index') }}">Packing Slips</a></li>
        <li>Stock Out</li>
    </ul> 
    <div class="row">
        <div class="col-sm-12">
            <h5>Slip No:- <span>{{$slip_no}}</span></h5>
            <div class="card">
                <div class="card-body">
                    <form id="myForm" method="POST" action="{{ route('admin.packingslip.save_goods_out') }}">
                    @csrf  
                    <input type="hidden" name="slip_no" value="{{$slip_no}}">   
                    @if($errors->any())            
                        {!! implode('', $errors->all('<p class="small text-danger">:message</p>')) !!}
                    @endif
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th colspan="">No of Ctns</th>
                                <th class="check-column">
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" id="">
                                        <label class="form-check-label" for=""></label>
                                    </div>
                                </th>
                                <th>Barcode per Ctn</th> 
                                <th>Stock In Weight</th>
                                <th>Scanned Weight</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @forelse ($data as $item)                            
                            <tr>
                                <td rowspan="{{ count($item->boxes) }}">{{$i}}</td>
                                <td rowspan="{{ count($item->boxes) }}">
                                    <label class="label-control">
                                        {{$item->pro_name}}  
                                    </label>
                                    
                                    <input type="hidden" name="quantity[{{$item->product_id}}]"  value="{{ count($item->boxes) }}">
                                </td>
                                <td rowspan="{{ count($item->boxes) }}">                                    
                                    <span>{{ count($item->boxes)  }}</span>
                                </td>
                                
                                @forelse ($item->boxes as $box)
                                  
                                <td class="check-column">
                                    <div class="form-check">
                                        @php                                    
                                            $checked = "checked=checked";
                                            if(empty($box->scan_no)){                                            
                                                $checked = "";
                                            }                                            
                                        @endphp 
                                        <input name="barcode_no[]" readonly onclick="return false"  class="form-check-input data-check" type="checkbox" {{$checked}}  value="{{$box->barcode_no}}" id="checkbox{{$box->barcode_no}}">
                                    </div>
                                </td>
                                <td>
                                    <span title="{{$box->barcode_no}}">
                                        {!! $box->code_html !!}
                                        <span style="width: 100%; display: block; text-align: center; color: #000000;">{{$box->barcode_no}}</span>
                                    </span>                                   
                                </td>
                                <td>
                                    {{$box->stock_in_weight_val / 1000}} kg
                                </td>
                                <td>
                                    <span id="scannedstockweight{{$box->barcode_no}}">
                                        {{($box->stock_out_weight_val / 1000)}} kg
                                    </span> 
                                </td>
                                <td>
                                    @if(!empty($box->scan_no))  
                                    <span class="badge bg-primary" id="scanstatus{{$box->barcode_no}}">Scanned</span>
                                    @else
                                    <span class="badge bg-secondary" id="scanstatus{{$box->barcode_no}}">Yet to Scan</span>
                                    @endif
                                    
                                    @if (!empty($box->is_new))
                                        <span class="badge bg-dark">New</span>
                                    @endif                                     
                                </td>
                                
                            </tr> 
                            
                            @empty
                            <tr></tr>
                            @endforelse
                            @php
                                $i++;
                            @endphp   
                            @empty
                                
                            @endforelse
                        <tbody>
                    </table> 
                    <div class="form-group">
                        <a href="{{ route('admin.packingslip.index') }}" class="btn btn-sm btn-danger">Back</a>
                        <button id="submitBtn" type="submit" class="btn btn-sm btn-success">Disburse</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
        var total_checkbox = $('input:checkbox.data-check').length;
        var total_checked = $('input:checkbox.data-check:checked').length;
        var slip_no = "{{ $slip_no }}";
        if(total_checked == total_checkbox){
            $('#submitBtn').prop('disabled', false);
        }else{
            $('#submitBtn').prop('disabled', true);
            const interval = setInterval(() => {        
                getScannedImages(slip_no);
            }, 5000);
        }
        $("#myForm").submit(function() {
            $('#submitBtn').attr('disabled', 'disabled');
            return true;
        });

                
    })

    function getScannedImages(slip_no){
        
        $.ajax({
            url: "{{ route('admin.packingslip.checkScannedboxes') }}",
            dataType: 'json',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "slip_no": slip_no
            },
            success: function(data){
                
                var sucessData = data;
                console.log(sucessData)
                
                // console.log(sucessData);
                for(var i = 0; i < sucessData.length; i++) {
                    // alert(sucessData[i].barcode_no)
                    var stock_out_weight_val = sucessData[i].stock_out_weight_val / 1000 ;
                    $('#scannedstockweight'+sucessData[i].barcode_no).text(stock_out_weight_val+' kg')
                    $('#scanstatus'+sucessData[i].barcode_no).text('Scanned');
                    $('#scanstatus'+sucessData[i].barcode_no).removeClass('badge bg-secondary');
                    $('#scanstatus'+sucessData[i].barcode_no).addClass('badge bg-primary');
                    $('#archivebtn'+sucessData[i].barcode_no).hide();
                    $('#checkbox'+sucessData[i].barcode_no).attr('checked', 'checked');

                    var total_checkbox = $('input:checkbox.data-check').length;
                    var total_checked = $('input:checkbox.data-check:checked').length;

                    if(total_checked == total_checkbox){
                        $('#submitBtn').prop('disabled', false);
                    }

                }
               
            }
        });
    }

    function downloadImage(name){
        var url = "https://bwipjs-api.metafloor.com/?bcid=code128&text="+name;

        fetch(url)
            .then(resp => resp.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                // the filename you want
                a.download = name;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(() => alert('An error sorry'));
    }
</script>
@endsection
