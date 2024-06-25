@extends('admin.layouts.app')
@section('page', 'Invoice of '.$user_name)
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Master</li>        
        <li><a href="{{ route('admin.staff.index') }}">Staff Management</a> </li>          
        <li>Invoice</li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="search__filter">
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        
                    </div>                    
                    <div class="col-auto">
                        
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('admin.invoice.staff',$id) }}" id="searchForm">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <input type="search" id="term" name="term" class="form-control" placeholder="Search here.." value="{{$term}}">
                                </div>                                
                                <input type="submit" hidden />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="filter">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">                            
                        {{-- <p> Items</p> --}}
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>      
                        <th>#</th>    
                        <th>Generated At</th>              
                        <th>Invoice No</th>
                        <th>Slip No</th>
                        <th>Order No</th>
                        <th>Store</th>
                        <th>Net Amount</th>
                        <th>Payment Status</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
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
                        <td> {{$item->invoice_no}}
                            <div class="row__action">
                                
                                {{-- <a href="{{ route('admin.store.delete', $item->id) }}" onclick="return confirm('Are you sure?');" class="text-danger">Delete</a> --}}
                            </div>
                        </td>
                        <td>{{$item->slip_no}}</td>
                        <td>{{$item->order_no}}</td>
                        <td>{{ $item->store_name }}</td>
                        <td>{{$item->net_price}}</td>
                        <td>
                            <span class="badge bg-{{$payment_class}}">{{$payment_status}}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.invoice.payments', [$item->id,$item->user_id,'staff'] ) }}" class="btn btn-sm btn-success">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>              
            {{-- {{$data->links()}} --}}
        </div>       
    </div>
</section>
<script>
    
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
    
</script>
@endsection

@section('script')

@endsection