@extends('admin.layouts.app')
@section('page', 'Order detail  #'.$data->order_no)
@section('content')
<section>    
    <div class="row">
        <div class="col-sm-12">    
            <div class="search__filter">
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        <a href="{{ route('admin.order.index', ['status'=>$data->status]) }}"  class="btn btn-outline-danger btn-sm">Back to Order</a>
                    </div>
                </div>                
            </div>    
            @php
            $gstText = "GST";
            if($data->is_gst == 0){
                $gstText = "NON-GST";
            }
            @endphp       
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <h6>Order Information</h6> 
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="small m-0">
                                            {{-- <strong>{{$gstText}}</strong> --}}
                                        </p>
                                    </div>
                                </div>                               
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Order Time :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{date('j M Y g:i A', strtotime($data->created_at))}}</p></div>
                                </div>
                                @if (!empty($data->order_location))
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Order Location :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->order_location}}</p></div>
                                </div>                                      
                                @endif   
                                @if (!empty($data->comment))
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Comment :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->comment}}</p></div>
                                </div>
                                @endif                           
                                
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <h6>Customer Details</h6>
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Person Name :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->stores['store_name']}}</p></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Company Name :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->stores['bussiness_name']}}</p></div>
                                </div>
                                @if (!empty($data->stores['email']))
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Email  :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->stores['email']}}</p></div>
                                </div>   
                                @endif
                                @if (!empty($data->stores['contact']))
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Mobile  :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->stores['contact']}}</p></div>
                                </div>   
                                @endif
                                @if (!empty($data->stores['whatsapp']))
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>WhatsApp  :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->stores['whatsapp']}}</p></div>
                                </div>   
                                @endif
                                <div class="row">
                                    <div class="col-sm-4"><p class="small m-0"><strong>Address :</strong></p></div>
                                    <div class="col-sm-8"><p class="small m-0">{{$data->stores['shipping_address']}}</p></div>
                                </div>
                                
                            </div>
                        </div>
                        @if(!empty($data->signature))
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <h6>Customer Signature</h6>
                                @php
                                    $signature = $data->signature;
                                @endphp
                                <div class="row">
                                    <img src="data:image/png;base64,{{$signature}}" style="height: 100px; width:200px;" alt="">
                                </div>                                
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        {{-- <th>Price per Ctn</th> --}}
                        {{-- <th>Pcs per Ctn</th> --}}
                        <th>Price per pcs (Inc.Tax)</th>
                        <th>Ordered</th>
                        <th>Delivered</th>
                        <th>Due</th>
                        <th>Total Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $sum_total_stock = 0;
                        $is_stock_av = 0;
                    @endphp
                    @foreach($data->orderProducts as $productKey => $productValue)

                    @php
                        $checkStockPO = checkStockPO($productValue->product_id,$productValue->qty);
                        $stockStatus = $checkStockPO['status'];
                        $stockCount = $checkStockPO['stock'];
                        $is_stock = $checkStockPO['is_stock'];
                        $pieces = $checkStockPO['pieces'];

                        $sum_total_stock += ($stockCount);
                        $is_stock_av += ($is_stock);

                        $rest_qty = ($productValue->qty - $productValue->release_qty);

                    @endphp
                    <tr>
                        <td>{{$i}}</td>
                        <td>
                            <p class="m-0">{{$productValue->product_name}}</p>
                        </td>
                        {{-- <td>
                            {{ number_format((float)$productValue->price, 2, '.', '') }}
                        </td> --}}
                        
                        <td>{{ number_format((float)$productValue->piece_price, 2, '.', '') }}</td>
                        <td>{{ $productValue->qty }} ctns ( {{$productValue->pcs}} pcs )</td>
                        <td>{{ $productValue->release_qty }} ctns ( {{$productValue->release_pcs}} pcs )</td>
                        <td>{{ $rest_qty }} ctns</td>
                        <td>
                            @if (!empty($is_stock))
                                {{ $stockCount }} ctns ( {{$pieces}} pcs )
                            @else
                                {{$stockStatus}}
                            @endif
                            
                        </td>
                    </tr>

                    @php
                        $i++;
                    @endphp
                    @endforeach
                </tbody>
            </table>            
            <div class="card shadow-sm">
                @php
                    $btn_class = "btn btn-sm btn-success";
                     
                @endphp

                <?php 
                    $disabled_packing_status_arr = array(3,4);
                    /* Button disabled if order is cancelled or completed */
                    if(!in_array($data->status, $disabled_packing_status_arr)){
                ?>
                <div class="card-body">
                    <a href="{{ route('admin.packingslip.add', $id) }}" class="{{$btn_class}}">Generate Packing Slip</a>
                    <a href="{{ route('admin.order.status', [$id, 3]) }}" onclick="return confirm('Are you sure want to cancel the order?');" class="btn btn-sm btn-danger">Cancel Order</a>
                    
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
        


    </div>
    
</section>
@endsection

@section('script')
    <script>
    </script>
@endsection
