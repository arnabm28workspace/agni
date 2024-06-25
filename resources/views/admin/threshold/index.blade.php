@extends('admin.layouts.app')
@section('page', 'Price Requests')
@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">   
            @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
            @endif                     
            <div class="filter">
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        <div class="row g-3 align-items-center">                            
                        </div>
                    </div>
                    <div class="col-auto">                        
                        <p>{{$total}} Total Requests</p>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Requested At</th>
                        <th>Request From</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Threshold Price (Inc.Tax)</th>
                        <th>Requested Price</th>
                        <th>Requested Quantity</th>
                        <th>Request Approval</th>
                        <th>Expired At</th>   
                        <th>Customer Approval</th>                         
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @forelse ($data as $index => $item)

                    @php
                        if(empty($item->is_approved)){
                            $statusText = "Yet to Approve";
                            $statusClass = "badge bg-warning";
                        }else if($item->is_approved == 1){
                            $statusText = "Approved";
                            $statusClass = "badge bg-success";
                        }else if($item->is_approved == 2){
                            $statusText = "Denied";
                            $statusClass = "badge bg-danger";
                        }
                    @endphp
                    <tr>
                        <td>{{ $i }}</td>     
                        <td>
                            {{ date('d/m/Y h:i A', strtotime($item->created_at))}}
                        </td>                               
                        <td>{{ $item->user_name }}</td>
                        <td>{{ $item->store_name }}</td>
                        <td>{{ $item->pro_name }}</td>
                        <td>{{ 'Rs. '.number_format((float)$item->sell_price, 2, '.', '') }}</td>
                        <td>{{ 'Rs. '.number_format((float)$item->price, 2, '.', '') }}</td>
                        <td>{{ $item->qty }} ctns ( {{$item->qty*10}} pcs )</td>
                        <td>
                            <span class="{{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            @if(!empty($item->expired_at) && ($item->is_approved == 1)) {{date('d/m/Y h:i A', strtotime($item->expired_at))}} @endif

                            @if(empty($item->is_approved))
                            {{-- <div class="row__action"> --}}
                                <a href="{{ route('admin.product.viewThresholdRequest', $item->id) }}" class="btn btn-sm btn-primary">Approve</a>     
                            {{-- </div> --}}
                            @endif
                        </td>     
                        <td>
                            @if (empty($item->is_approved))
                                <span class="badge bg-warning">Yet to Receive</span>
                            @elseif ($item->is_approved == 1)
                                @if (empty($item->customer_approval) && ($item->customer_approval != 2) )
                                    <a href="{{ route('admin.product.viewRequestedPriceReceiveOrder', $item->id) }}" class="btn btn-sm btn-primary">Place Order</a>  
                                @else
                                    @php
                                        $customer_approval_text = "Received";
                                        $customer_approval_class = "success";
                                    @endphp 
                                    <span class="badge bg-{{$customer_approval_class}}">{{ $customer_approval_text }}</span> <br> 
                                    <span>Order No: <strong>{{$item->order_no}}</strong></span>  
                                @endif
                            @else
                                <span class="badge bg-danger">Denied Request</span>
                            @endif
                                
                            
                            
                        </td>                   
                    </tr>
                    @php
                        $i++;
                    @endphp

                    @empty
                    <tr><td colspan="100%" class="small text-muted text-center">No data found</td></tr>
                    @endforelse
                </tbody>
            </table> 
            {{ $data->links() }}
        </div>        
    </div>
</section>
<script>
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
    })  
    
</script>
@endsection

