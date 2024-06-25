@extends('admin.layouts.app')
@section('page', 'Generate GRN')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li><a href="{{ route('admin.purchaseorder.index') }}">PO</a></li>
        <li><a href="{{route('admin.purchaseorder.view',$id)}}">{{$unique_id}}</a></li>
        <li>Generate GRN</li>
    </ul>
    
    @if (empty($goods_in_type))
    <div class="row">
        <form action="" method="GET">  
        <div class="row">
            <div class="col-md-4">
                    <div class="form-group d-flex align-items-center" style="height: 30px;">
                        <label for="">Goods In With  </label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input choose-type" type="radio" name="goods_in_type" id="scan" value="scan">
                            <label class="form-check-label" for="scan">Scan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input choose-type" type="radio" name="goods_in_type" id="bulk" value="bulk">
                            <label class="form-check-label" for="bulk">Bulk</label>
                        </div>
                    </div>
                
            </div>
            <div class="col-md-4">
                <div class="d-flex flex-row">
                    <a href="{{ route('admin.purchaseorder.index') }}" class="btn btn-danger select-md">Back</a>
                    <button type="submit" class="btn btn-success select-md" id="nextBtn">Next</button>
                </div>
            </div>
        </div>          
       
        </form>
    </div>
    @endif

    @if(!empty($goods_in_type))
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
                   
                    <div class="col">                        
                        <div class="row g-3 align-items-center">
                            <form action="" id="searchForm">
                                
                            <div class="col-auto">
                                <input type="search" name="search" id="search" class="form-control" placeholder="Search here.." value="{{$search}}" autocomplete="off">                                
                            </div>  
                            <input type="submit" hidden /> 
                            </form>                             
                        </div>                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" method="POST" action="{{ route('admin.purchaseorder.saveinventory') }}">
                    @csrf  
                    <input type="hidden" name="unique_id" value="{{$unique_id}}">          
                    <input type="hidden" name="" id="total_checked" value="{{$total_checked}}">           
                    <input type="hidden" name="id" value="{{$id}}"> 
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
                                <th>Weight per Ctn</th>
                                <th>Scanned Weight</th>
                                <th>Pcs per Ctn</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @forelse ($data as $product_id => $barcodes) 
                            @php
                                // dd($item);
                                $pro_name = getSingleAttributeTable('products',$product_id,'name');
                                $getPODetails = getPODetails($id,$product_id);
                                $weight = $getPODetails->weight;
                                $weight_unit = $getPODetails->weight_unit;
                            @endphp                           
                            <tr>
                                <td rowspan="{{ count($barcodes) }}">{{$i}}</td>
                                <td rowspan="{{ count($barcodes) }}">
                                    <label class="label-control">
                                        {{$pro_name}}  
                                    </label>
                                    <br/>
                                    
                                    <input type="hidden" name="quantity[{{$product_id}}]"  value="{{ count($barcodes) }}">
                                </td>
                                <td rowspan="{{ count($barcodes) }}">                                    
                                    <span>{{ count($barcodes)  }}</span>
                                </td>
                                
                                @forelse ($barcodes as $box)
                                  
                                <td class="check-column">
                                    <div class="form-check">
                                        @php                                    
                                            $checked = "checked=checked";
                                            if($box->is_scanned == 0){                                            
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
                                    {{$weight}} {{$weight_unit}}
                                </td>
                                <td>
                                    <span id="scannedweight{{$box->barcode_no}}">
                                        @if (!empty($box->scanned_weight_val))
                                            {{$box->scanned_weight_val / 1000}} kg
                                        @endif
                                        
                                    </span>
                                </td>
                                <td>
                                    {{$box->pcs}} pieces
                                </td>
                                <input type="hidden" name="pcs[]" value="{{$box->pcs}}">
                                <td>
                                    @if($box->is_scanned == 1)
                                    <span class="badge bg-primary" id="scanstatus{{$box->barcode_no}}">Scanned</span>
                                    @else
                                    <span class="badge bg-secondary" id="scanstatus{{$box->barcode_no}}">Yet to Scan</span>
                                    @endif
                                    
                                    @if (!empty($box->is_new))
                                        <span class="badge bg-dark">New</span>
                                    @endif                                     
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="downloadImage('{{$box->barcode_no}}')" >DOWNLOAD</button>
                                    
                                    <?php 
                                        if($box->is_scanned == 0){
                                    ?>
                                    <a href="{{ url('/admin/purchaseorder/archiveBox'.'/'.$unique_id.'/'.$product_id.'/'.$box->barcode_no) }}" onclick="return confirm('Are you sure want to archive box?');" class="btn btn-warning" id="archivebtn{{$box->barcode_no}}">Archive</a>
                                    <?php 
                                        }   
                                    ?>
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
                        <a href="{{ route('admin.purchaseorder.index') }}" class="btn btn-sm btn-danger">Back</a>
                        <button id="submitBtn" type="submit" class="btn btn-sm btn-success">Generate</button>

                        <br/>
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
    @endif
    
</section>
<script>
    var search = "{{$search}}";
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
        $('#nextBtn').attr('disabled',true);
        var goods_in_type = "{{ $goods_in_type }}";

        $('.choose-type').on('click', function(){
            $('#nextBtn').attr('disabled',false);
        })


        var total_checkbox = $('input:checkbox.data-check').length;
        var total_checked = $('input:checkbox.data-check:checked').length;

        var id = "{{ $id }}"
        if(goods_in_type != '' && goods_in_type == 'scan'){
            if(total_checked == total_checkbox){
                $('#submitBtn').prop('disabled', false);
            }else{
                $('#submitBtn').prop('disabled', true);
                const interval = setInterval(() => {        
                    getScannedImages(id);
                }, 5000);
            }
        }
        
        $("#myForm").submit(function() {
            if(search == ''){
                $('#submitBtn').prop('disabled', false);
            } else {
                $('#submitBtn').prop('disabled', true);
            }  
        });

                
    })

    $('input[type=search]').on('search', function () {
        // search logic here
        // this function will be executed on click of X (clear button)
        $('#searchForm').submit();
    });

    function getScannedImages(id){
        $.ajax({
            url: "{{ route('admin.purchaseorder.checkScannedboxes') }}",
            dataType: 'json',
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            success: function(data){
                
                var sucessData = data;
                console.log(sucessData)
                
                // console.log(sucessData);
                for(var i = 0; i < sucessData.length; i++) {
                    // alert(sucessData[i].barcode_no)
                    var scanned_weight_val = (sucessData[i].scanned_weight_val / 1000);
                    $('#scanstatus'+sucessData[i].barcode_no).text('Scanned');
                    $('#scannedweight'+sucessData[i].barcode_no).text(scanned_weight_val+' kg');
                    $('#scanstatus'+sucessData[i].barcode_no).removeClass('badge bg-secondary');
                    $('#scanstatus'+sucessData[i].barcode_no).addClass('badge bg-primary');
                    $('#archivebtn'+sucessData[i].barcode_no).hide();
                    $('#checkbox'+sucessData[i].barcode_no).attr('checked', 'checked');

                    var total_checkbox = $('input:checkbox.data-check').length;
                    var total_checked = $('input:checkbox.data-check:checked').length;

                    $('#total_checked').val(sucessData.length);
                    var new_total_checked = $('#total_checked').val();
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
