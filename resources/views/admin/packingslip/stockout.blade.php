@extends('admin.layouts.app')
@section('page', 'Stock Out')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Sales</li>
        <li><a href="{{ route('admin.packingslip.index') }}">Packing Slips ({{$slip_no}})</a></li>
        <li>Stock Out</li>
    </ul> 
    <div class="search__filter">
        <div class="row align-items-center justify-content-between">
            <div class="col">
                @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
            </div>
            <div class="col-auto">
                <div class="row">                        
                    <div class="col-auto">
                        
                    </div>
                    <div class="col">                        
                        <div class="row g-3 align-items-center">
                            <form action="" id="searchForm">
                                
                            <div class="col-auto">
                                <input type="search" name="search" id="search" class="form-control" placeholder="Search barcode.." value="{{$search}}" autocomplete="off">                                
                            </div>  
                            <input type="submit" hidden /> 
                            </form>                             
                        </div>                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                
            </div>
            <div class="col-auto">    
                {{$totalData}} items  
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {{-- <h5>Slip No:- <span>{{$slip_no}}</span></h5> --}}
            <div class="card">
                <div class="card-body">
                    <form id="myForm" method="POST" action="{{ route('admin.packingslip.save_goods_out') }}">
                        <input type="hidden" name="" id="total_checked" value="{{$total_checked}}">
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
                                <th colspan="">Required Ctns</th>
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
                            @forelse ($data as $product_id => $barcodes)   
                            
                            @php
                                $pro_name = getSingleAttributeTable('products',$product_id,'name');
                                $get_packing_slip = get_packing_slip($slip_no,$product_id);
                                $quantity = $get_packing_slip->quantity;
                            @endphp
                            {{-- {{ count($item->boxes) }} --}}
                            {{-- {{ count($barcodes) }} --}}
                            <tr>
                                <td rowspan="{{count($barcodes)}}">{{$i}}</td>
                                <td rowspan="{{count($barcodes)}}">
                                    <label class="label-control">
                                        {{$pro_name}}  
                                    </label>
                                    
                                    <input type="hidden" name=""  value="">
                                </td>
                                <td rowspan="{{count($barcodes)}}">                                    
                                    <span>{{$quantity}}</span>
                                </td>
                                <input type="hidden" name="products[]" value="{{$product_id}}">
                                
                                @forelse ($barcodes as $box)
                                  
                                <td class="check-column">
                                    <div class="form-check">
                                        @php                                    
                                            $checked = "checked=checked";
                                            if(empty($box->scan_no)){                                            
                                                $checked = "";
                                            }                                            
                                        @endphp 
                                        <input name="barcode[]" readonly onclick="return false"  class="form-check-input data-check" type="checkbox" {{$checked}}  value="{{$box->barcode_no}}" id="checkbox{{$box->barcode_no}}">
                                    </div>
                                </td>
                                <td>
                                    <span title="{{$box->barcode_no}}">
                                        {!! $box->code_html !!}
                                        <span style="width: 100%; display: block;  color: #000000;">{{$box->barcode_no}} ({{$box->pcs}} pcs)</span>
                                    </span>                                   
                                </td>
                                <td>
                                    {{$box->stock_in_weight_val / 1000}} kg
                                </td>
                                <td>
                                    <span id="scannedstockweight{{$box->barcode_no}}">
                                        @if (!empty($box->stock_out_weight_val))
                                            {{($box->stock_out_weight_val / 1000)}} kg
                                        @endif
                                        
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
                        <br>
                        
                        <span>** Currently scanned total <strong id="total_checked_span">{{$total_checked}}</strong> boxes  </span>
                                                
                        <br/>
                        @if (!empty($search))
                        <span>Please clear search data to preceed</span>                            
                        @endif
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var total_checkbox = "{{$total_checkbox}}";
    var total_checked = "{{$total_checked}}";
    var search = "{{$search}}";
    console.log('search:- '+search);

    $('input[type=search]').on('search', function () {
        // search logic here
        // this function will be executed on click of X (clear button)
        $('#searchForm').submit();
    });
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
        // var total_checkbox = $('input:checkbox.data-check').length;
        // var total_checked = $('input:checkbox.data-check:checked').length;
        
        console.log('total_checked:- '+total_checked)
        console.log('total_checkbox:- '+total_checkbox)
        var slip_no = "{{ $slip_no }}";
        if(total_checkbox == total_checked){            
            // $('#submitBtn').prop('disabled', false);   
            if(search == ''){
                $('#submitBtn').prop('disabled', false);
            } else {
                $('#submitBtn').prop('disabled', true);
            }         
            
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

                    // var total_checkbox = $('input:checkbox.data-check').length;
                    // var total_checked = $('input:checkbox.data-check:checked').length;
                    $('#total_checked').val(sucessData.length);
                    var new_total_checked = $('#total_checked').val();
                    console.log('new_total_checked:- '+new_total_checked);
                    console.log('total_checked:- '+total_checked);
                    $('#total_checked_span').text(new_total_checked);
                    if(total_checkbox == new_total_checked){
                        if(search == ''){
                            $('#submitBtn').prop('disabled', false);
                        } else {
                            $('#submitBtn').prop('disabled', true);
                        }
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
