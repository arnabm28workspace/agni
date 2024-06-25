@extends('admin.layouts.app')
@section('page', 'Payment Collection')
@section('content')

@php
$store_id = (isset($_GET['store_id']) && $_GET['store_id']!='')?$_GET['store_id']:'';
$staff_id = (isset($_GET['staff_id']) && $_GET['staff_id']!='')?$_GET['staff_id']:'';
@endphp
<section>
    <ul class="breadcrumb_menu">
        <li>Report</li>
        <li><a href="{{ route('admin.paymentcollection.index') }}">Payment Collection</a></li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
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
                        <form action="" method="GET">
                            <div class="row g-3 align-items-center">                    
                                <div class="col-auto">
                                    <select name="store_id" class="form-control select-sm">
                                        <option value="" hidden selected>Customer</option>
                                        @foreach($stores as $store)
                                        <option value="{{$store->id}}" @if($store_id==$store->id){{"selected"}}@endif>{{$store->store_name}}</option>
                                        @endforeach
                                    </select>                    
                                </div>
                                <div class="col-auto">                    
                                    <select name="staff_id" class="form-control select-sm">
                                        <option value="" hidden selected>Collected By</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" @if($staff_id==$user->id){{"selected"}}@endif>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                <button type="submit" class="btn btn-outline-success  select-sm">Search</button>
                                </div>
                                <div class="col-auto">
                                <a href="{{ route('admin.paymentcollection.index') }}" class="btn btn-outline-danger  select-sm">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="filter">
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        
                    </div>
                    <div class="col-auto">
                        <p>{{$total}} Items</p>
                    </div>
                </div>
            </div>

            <table class="table table-sm table-hover ledger">
                <thead>
                <tr> 
                    <th>#</th>      
                    <th>Collected At</th>    
                    <th>Collected By</th> 
                    <th>Customer</th>
                    <th>Collection Amount</th>
                    <th>Payment Date</th>
                    <th>Approval</th>
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
                    <tr class="store_details_row">   
                        <td>{{$i}}</td>        
                        <td>
                            <p class="small text-muted mb-1">{{ date('d/m/Y H:i A', strtotime($item->created_at)) }} </p>
                        </td>       
                        <td>
                            @if (!empty($item->users))
                            <p class="small text-muted mb-1">{{$item->users['name']}}</p>
                            @else
                            <p class="small text-muted mb-1">{{$item->admins['name']}}</p>  
                            @endif
                            
                        </td>         
                        <td>                            
                            <p class="small text-muted mb-1">
                                {{$item->stores['store_name']}}
                                {{-- @if (!empty($item->stores['store_name']))
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
                                @endif                                 --}}
                            </p>
                            
                        </td>
                        <td>
                            <p class="small text-muted mb-1">Rs. {{number_format((float)$item->collection_amount, 2, '.', '')}} ({{ucwords($item->payment_type)}})</p>
                        </td>
                        <td>
                            <p class="small text-muted mb-1"> 
                                {{date('d/m/Y', strtotime($item->cheque_date))}}
                            </p>                            
                        </td>    
                        <td>
                            @if (!empty($item->is_ledger_added))
                                <span class="badge bg-success">Approved</span>                                
                            @else
                                <a href="{{ route('admin.accounting.add_payment_receipt',$item->id) }}" class="btn btn-sm btn-warning">Approve</a>
                            @endif
                        </td>                            
                    </tr>  
                    <tr>                        
                        <td colspan="5" class="store_details_column">
                            <div class="store_details">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <span>Customer Name: <strong>{{$item->stores['store_name']}} </strong> </span> 
                                        </td>
                                        @if (!empty($item->stores['bussiness_name']))
                                        <td>
                                            <span>Company Name: <strong>{{$item->stores['bussiness_name']}} </strong> </span> 
                                        </td> 
                                        @endif  
                                        @if (!empty($item->stores['contact']))
                                        <td>                                            
                                            <span>Phone: <strong>{{$item->stores['contact']}} </strong> </span>  
                                        </td>  
                                        @endif    
                                        @if (!empty($item->stores['whatsapp']))                                      
                                        <td>
                                            <span>WhatsApp: <strong>{{$item->stores['whatsapp']}} </strong> </span> 
                                        </td>  
                                        @endif
                                    </tr>                                    
                                    <tr>   
                                        @if (!empty($item->bank_name))
                                        <td><span>Bank: <strong>{{ ($item->bank_name)}}</strong></span></td>    
                                        @endif
                                        @if (!empty($item->payment_type))
                                        <td><span>Bank: <strong>{{ ucwords($item->payment_type)}}</strong></span></td>    
                                        @endif
                                        @if (!empty($item->chq_utr_no))
                                        <td><span>Cheque / UTR No: <strong>{{ ucwords($item->cheque_number)}}</strong></span></td>    
                                        @endif
                                        @if (!empty($item->cheque_date))
                                        <td><span>Payment Date: <strong>{{ date('d/m/Y', strtotime($item->cheque_date))}}</strong></span></td>    
                                        @endif
                                        @if (!empty($item->vouchar_no))
                                        <td><span>Voucher No: <strong>{{ ($item->vouchar_no)}}</strong></span></td>    
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp          
                    @endforeach
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
</script>
@endsection
