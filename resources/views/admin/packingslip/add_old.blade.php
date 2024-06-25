@extends('admin.layouts.app')
@section('page', 'Packing Slip')
@section('content')
<section>
    <h4>Order No:- <span>#{{$order->order_no}}</span></h4>
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
            <form action="{{ route('admin.packingslip.save') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{$order_id}}">

            @php
                $submit_disabled = "disabled";
            @endphp
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Required Quantity</th>
                        <th>Disburse Quantity</th>
                        <th>Total Stock</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse ($order_products as $op)
                        
                    @php
                        $checkStockPO = checkStockPO($op->product_id,$op->qty);
                        $stockStatus = $checkStockPO['status'];
                        $maxStock = $checkStockPO['stock'];
                        $is_stock = $checkStockPO['is_stock'];
                        $pieces = $checkStockPO['pieces'];

                        $disabled = "";

                        $get_product_ctns_pcs_ps = get_product_ctns_pcs_ps($order_id,$op->product_id);
                        $no_of_ctns = $get_product_ctns_pcs_ps['no_of_ctns'];
                        $total_pcs = $get_product_ctns_pcs_ps['total_pcs'];
                        $barcode_nos = $get_product_ctns_pcs_ps['barcode_nos'];
                        // dd($barcode_nos);

                        if(!empty($no_of_ctns)){
                            $submit_disabled = "";
                        }
                        
                        $required_qty = ($op->qty - $op->release_qty);
                        
                        if($is_stock == 0){
                            $disabled = "disabled";
                        }
                        if($op->qty == $op->release_qty){
                            $disabled = "disabled";
                        }

                        if($maxStock >= $required_qty){
                            $max = $required_qty;
                        }else{
                            $max = $maxStock;
                        }

                    @endphp
                    <tr>                        
                        <td>
                            <p class="m-0">
                                {{$op->pro_name}}
                            </p>
                        </td>
                        <td>
                            <p class="m-0">
                                {{$required_qty}} ctns ( {{$required_qty * $op->pcs}} pcs )
                            </p>
                        </td>
                        <td>
                            {{-- <input type="number" id="qty{{$op->product_id}}" {{$disabled}} class="form-control" @if($disabled == "") value="1" @endif min="1" max="{{ $max }}"  name="qty[{{$op->product_id}}]" > --}}
                            @if (!empty($no_of_ctns))
                                <span>{{$no_of_ctns}} ctns ({{$total_pcs}} pcs)</span>
                                <input type="hidden" name="qty[]" value="{{$no_of_ctns}}">
                                <input type="hidden" name="pcs[]" value="{{$total_pcs}}"> 
                                <input type="hidden" name="barcode[]" value="{{$barcode_nos}}">
                                <a href="{{ route('admin.packingslip.removepieces', [$order_id,$op->product_id]) }}" class="btn btn-sm btn-outline-danger">Remove Cartons</a>
                            @endif
                            <input type="hidden" name="product[]" value="{{$op->product_id}}">   
                            
                        </td>
                        
                        <td>
                            @if (!empty($is_stock) && !empty($required_qty))
                                {{ $maxStock }} ctns ( {{$pieces}} pcs )
                                <a href="{{ route('admin.packingslip.pieces', [$order_id,$op->product_id,$required_qty,($required_qty * $op->pcs)]) }}" class="btn btn-sm btn-outline-success">Get Cartons</a>
                            @else
                                {{$stockStatus}}
                            @endif
                             
                        </td>
                    </tr>
                    
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="{{ route('admin.order.index',['status'=>$order->status]) }}" class="btn btn-sm btn-danger">Back</a>
                    <input type="submit" {{$submit_disabled}} class="btn btn-sm btn-success" value="Generate Packing Slip" />
                </div>
            </div>
            </form>
        </div>
    </div>
    
</section>
@endsection

@section('script')
    <script>
        
        // $("[type='number']").keypress(function (evt) {
        //     evt.preventDefault();
        // });

        $(document).ready(function(){
            $('div.alert').delay(3000).slideUp(300);
        })

        
    </script>
@endsection
