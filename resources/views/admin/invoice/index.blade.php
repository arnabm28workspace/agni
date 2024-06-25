@extends('admin.layouts.app')
@section('page', 'Invoices')
@section('content')
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="search__filter">
                <form action="" id="searchForm">  
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                        @endif   
                    </div>                  
                    <div class="col-auto">
                        <select name="type" id="type" class="form-control">
                            <option value="" @if(empty($type)) selected @endif>All Type</option>
                            <option value="gst" @if($type == 'gst') selected @endif>GST</option>
                            <option value="non_gst" @if($type == 'non_gst') selected @endif>NON-GST</option>
                        </select>
                    </div>
                    <div class="col-auto">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <input type="search" id="term" name="term" class="form-control" placeholder="Search invoice no..." value="{{$term}}">
                                </div>                                
                                <input type="submit" hidden />
                            </div>
                    </div>
                </div>
            </form>
            </div>
            
            <div class="filter">
                <div class="row align-items-center justify-content-between">
                    <div class="col">

                    </div>
                    <div class="col-auto">                        
                        <p>{{$total}} Total invoices</p>                        
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>      
                        <th>#</th>    
                        <th>Generated At</th>              
                        <th>Invoice No</th>  
                        <th>Order No</th>                      
                        <th>Customer Details</th>
                        <th>Net Amount</th>
                        <th>Due Amount</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        if(empty(Request::get('page')) || Request::get('page') == 1){
                            $i=1;
                        } else {
                            $i = (((Request::get('page')-1)*$paginate)+1);
                        } 
                    @endphp
                    @forelse ($data as $index => $item)

                    @php
                        $payment_status = 'Not Paid';
                        $payment_class = 'danger';
                        if($item->payment_status == 0){
                            $payment_status = 'Not Paid';
                            $payment_class = 'danger';
                        }else if($item->payment_status == 1){
                            $payment_status = 'Half Paid';
                            $payment_class = 'warning';
                        }else if($item->payment_status == 2){
                            $payment_status = 'Full Paid';
                            $payment_class = 'success';
                        }
                    @endphp
                    <tr>        
                        <td>{{$i}}</td>   
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>             
                        <td>{{$item->invoice_no}} </td>
                        <td><a href="{{ route('admin.order.view', $item->order_id) }}">{{$item->order_no}}</a> </td>
                        <td>
                            <p class="small text-muted mb-1">
                                @if (!empty($item->store_name))
                                <span>Person Name: <strong>{{$item->store_name}}</strong> </span> <br/>   
                                @endif
                                @if (!empty($item->bussiness_name))
                                <span>Company Name: <strong>{{$item->bussiness_name}}</strong> </span> <br/>    
                                @endif
                                @if (!empty($item->contact))
                                <span>Mobile: <strong>{{$item->contact}}</strong> </span> <br/>
                                @endif
                                @if (!empty($item->whatsapp))
                                <span>WhatsApp: <strong>{{$item->whatsapp}}</strong> </span> <br/>    
                                @endif                                
                            </p>
                        </td>
                        <td>Rs. {{ number_format((float)$item->net_price, 2, '.', '') }}</td>
                        <td>Rs. {{ number_format((float)$item->required_payment_amount, 2, '.', '') }}</td>
                        <td>
                            <span class="badge bg-{{$payment_class}}">{{$payment_status}}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.packingslip.view_invoice', $item->invoice_no) }}" class="btn btn-sm btn-success">Download</a>   
                            <a href="{{ route('admin.invoice.payments', $item->id ) }}" class="btn btn-sm btn-success">View Payments</a>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @empty
                    <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>              
            {{$data->links()}}
        </div>       
    </div>
</section>
<script>
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
    })
    
    $('input[type=search]').on('search', function () {        
        $('#searchForm').submit();
    });

    $('#term').on('keyup', function(){
        var timer;
        clearTimeout(timer);
        timer=setTimeout(()=>{ 
            $('#searchForm').submit();
        },1500);
    });

    $('#type').on('change', function(){
        $('#searchForm').submit();
    })
    
</script>
@endsection

@section('script')

@endsection