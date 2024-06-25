@extends('admin.layouts.app')
@section('page', 'View Stocks')
@section('content')
<section>
    <div class="search__filter">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                <div class="row">
                    <div class="col">                
                        <div class="row g-3 align-items-center">                            
                            <div class="col-auto">
                                <a href="{{ route('admin.purchaseorder.index') }}" class="btn btn-outline-danger btn-sm">Back</a>
                            </div>
                        </div>
                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="row mb-2 align-items-center">
                <div class="col-3">
                    <label for="inputPassword6" class="col-form-label">Order Id</label>
                </div>
                <div class="col-9">
                    <p class="">#{{$data->po_unique_id}}</p>
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-3">
                    <label for="inputPassword6" class="col-form-label">GRN No</label>
                </div>
                <div class="col-9">
                    <p class="">{{$data->grn_no}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">  
            <table class="table">
                <thead>
                    <tr>    
                        <th>#</th>  
                        <th>Product</th>
                        <th>Box Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @forelse ($data->stock_products as $pro)
                    <tr>   
                        <td>{{$i}}</td> 
                        <td>{{ $pro->pro_name }}</td>
                        <td>{{ $pro->quantity }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @empty
                    <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>                 
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-12">  
            <table class="table">
                <thead>
                    <tr>    
                        <th>#</th> 
                        <th>Barcode No</th>
                        <th>Product</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @forelse ($data->stock_boxes as $box)
                    <tr>   
                        <td>{{$i}}</td>  
                        <td><span title="{{ $box->barcode_no }}">{!! $box->code_html !!}</span></td> 
                        <td>{{ $box->pro_name }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @empty
                    <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>                 
        </div>
        
    </div>
</section>

@endsection

