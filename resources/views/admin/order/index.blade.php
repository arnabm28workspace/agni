@extends('admin.layouts.app')
{{-- @section('page', 'Order') --}}
@if (!empty($status))
    @if ($status == 1)
        @section('page', 'Received Orders')
    @elseif ($status == 2)
        @section('page', 'Pending Orders')
    @elseif ($status == 3)
        @section('page', 'Cancelled Orders')
    @elseif ($status == 4)
        @section('page', 'Completed Orders')
    @endif
    @else
        @section('page', 'All Order')
@endif
@section('content')

@php
$store_id = (isset($_GET['store_id']) && $_GET['store_id']!='')?$_GET['store_id']:'';
$staff_id = (isset($_GET['staff_id']) && $_GET['staff_id']!='')?$_GET['staff_id']:'';
$order_id = (isset($_GET['order_id']) && $_GET['order_id']!='')?$_GET['order_id']:'';
@endphp
<section>
    @if($errors->any())                      
        {!! implode('', $errors->all('<p class="small text-danger">:message</p>')) !!}
    @endif
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="container-fliud">
        <div class="row">
            <div class="col-sm-4">
                <div class="filter">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <p>{{$data->count()}} Items</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="search__filter">
                    <div class="row align-items-center justify-content-between">
                    <div class="col">
                        
                    </div>
                    <div class="col-auto">
                        <form id="searchForm">
                            <input type="hidden" name="status" value="{{$status}}">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <input type="search" name="order_id" id="order_id" class="form-control" placeholder="Order Id"
                                    value="{{$order_id}}"
                                    autocomplete="off">
                                </div>
                                <div class="col-auto">
                                    <select name="store_id" class="form-control searchDropdown">
                                        <option value="">Select Store</option>
                                        @foreach($stores as $store)
                                        <option value="{{$store->id}}" @if($store_id==$store->id){{"selected"}}@endif>{{$store->store_name}}</option>
                                        @endforeach
                                    </select>                                
                                </div>
                                <div class="col-auto">                                
                                    <select name="staff_id" class="form-control searchDropdown">
                                        <option value="">Select Staff</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" @if($staff_id==$user->id){{"selected"}}@endif>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    {{-- <button type="submit" class="btn btn-outline-danger btn-sm">Search</button> --}}
                                    <input type="submit" hidden>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('admin.order.index', ['status'=>$status]) }}" class="btn btn-outline-danger btn-sm">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
           
            <th>#</th>
            <th>Ordered At</th>
            <th>Order Id</th>
            <th>Customer Details</th>
            <th>Placed By</th>
            <th>Products</th>
            <th>Order Amount (Inc.Tax)</th>
            <th>Order Status</th>
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
            @foreach ($data as $index => $item)
            @php
                $pro_id_arr = explode(",",$item->pro_ids);
                $groupConcatNames = groupConcatNames('products','name',$pro_id_arr);
                $viewDetailText = "Generate Packing Slip";
                if($item->status == 3 || $item->status == 4){
                    $viewDetailText = "View Details";
                }
            @endphp
            <tr>
                <td>
                    {{$i}}
                </td>               
                <td>
                    <p class="small">{{date('j M Y g:i A', strtotime($item->created_at))}}</p>
                </td>   
                <td>
                    <p class="small text-dark mb-1">#{{$item->order_no}}</p>
                    <div class="row__action">
                        @if (in_array($item->status,[1,2]))
                        <a href="{{ route('admin.packingslip.add',$item->id) }}">Generate Packing Slip</a>
                        @else
                            
                        @endif
                        <a href="{{ route('admin.order.view', $item->id) }}">Details</a>
                       
                    </div>
                </td>
                <td>
                    <p class="small text-muted mb-1">
                        @if (!empty($item->stores['store_name']))
                        <span>Person Name: <strong>{{$item->stores['store_name']}}</strong> </span> <br>    
                        @endif
                        @if (!empty($item->stores['bussiness_name']))
                        <span>Company Name: <strong>{{$item->stores['bussiness_name']}}</strong> </span>    <br> 
                        @endif
                        @if (!empty($item->stores['contact']))
                        <span>Mobile : <strong>{{$item->stores['contact']}}</strong> </span> <br>   
                        @endif
                        @if (!empty($item->stores['whatsapp']))
                        <span>WhatsApp : <strong>{{$item->stores['whatsapp']}}</strong> </span>   
                        @endif
                    </p>
                </td>
                <td>
                    <p class="small text-muted mb-1">{{$item->users['name']}}</p>
                </td>
                <td>
                    <p>{{$groupConcatNames}}</p>
                </td>
                <td>
                    <p class="small text-muted mb-1">Rs {{ number_format((float) $item->final_amount, 2, '.', '')}}</p>
                </td>           
                <td>
                    <?php 
                        if ($item->status == 1) {
                            $status = "Received";
                            $status_class = "success";
                        }else if ($item->status == 2) {
                            $status = "Pending";
                            $status_class = "warning";
                        }else if ($item->status == 3) {
                            $status = "Cancelled";
                            $status_class = "danger";
                        }else  {
                            $status = "Completed";
                            $status_class = "primary";
                        }
                    ?>
                    <span class="badge bg-{{$status_class}}">
                        {{$status}}
                    </span>
                </td>                
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
    {{$data->links()}}
</section>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
    })

    $('input[type=search]').on('search', function () {
        // search logic here
        // this function will be executed on click of X (clear button)
        $('#searchForm').submit();
    });

    $('#order_id').on('keyup', function(){
        var timer;
        clearTimeout(timer);
        timer=setTimeout(()=>{ 
            $('#searchForm').submit();
         },1500);
    });

    $('.searchDropdown').on('change', function(){
        $('#searchForm').submit();
    });
</script>
@endsection
