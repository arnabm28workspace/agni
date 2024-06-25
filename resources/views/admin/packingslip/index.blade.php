@extends('admin.layouts.app')
@section('page', 'Packing Slips')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Sales</li>
        <li>Packing Slip</li>
    </ul>   
    <div class="search__filter">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                <div class="row">
                    <div class="col">                
                        <div class="row g-3 align-items-center">                            
                            <div class="col-auto">

                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>
    </div> 
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
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Generated At</th>
                        <th>Slip No</th>
                        <th>Order No</th>
                        <th>Products</th>
                        <th>No of Ctns</th>
                        {{-- <th>Scanned Ctns</th> --}}
                        <th>Status</th>
                        <th>Action</th>
                        {{-- <th>TRN</th> --}}
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
                    @forelse ($data as $item)
                    @php
                        $pro_id_arr = explode(",",$item->pro_ids);
                        $groupConcatNames = groupConcatNames('products','name',$pro_id_arr);

                        if(!empty($item->is_disbursed)){
                            $statusText = "Disbursed";
                            $statusClass = "success";
                        } else {
                            $statusText = "Yet to Disburse";
                            $statusClass = "warning";
                        }

                    @endphp  
                    <tr>  
                        <td>{{$i}}</td>
                        <td>
                            <p class="m-0">
                                {{date('d/m/Y H:i A', strtotime($item->created_at))}}
                            </p>
                        </td> 
                        <td><p class="m-0"> {{$item->slip_no}} </p></td> 
                        <td><a href="{{ route('admin.order.view', $item->order_id) }}"> {{$item->order_no}}</a></td>   
                        <td>
                            {{$groupConcatNames}}
                        </td>
                        <td>
                            <p>{{ $item->total_qty }}</p>
                        </td> 
                        {{-- <td>
                            <p>{{ $item->scanned_boxes }}</p>
                        </td> --}}
                        <td>
                            <span class="badge bg-{{$statusClass}}">{{$statusText}}</span>
                        </td>
                        <td>
                            
                            @if (empty($item->is_disbursed))
                                <a href="{{ route('admin.packingslip.view_goods_stock', $item->slip_no) }}" class="btn btn-sm btn-warning">Stock Out</a>
                            @else
                                <a href="{{ route('admin.packingslip.get_pdf', $item->slip_no) }}" class="btn btn-sm btn-success" >Download</a>
                            @endif
                            
                            @if (!empty($item->is_disbursed))
                                @if (!empty($item->is_invoice_raised))
                                
                                @else
                                @if (!empty($item->is_gst))
                                <a href="{{ route('admin.packingslip.raise_invoice_form', $item->slip_no) }}" class="btn btn-sm btn-warning">Raise Invoice</a> 
                                @else
                                <a href="{{ route('admin.packingslip.raise_invoice_form', $item->slip_no) }}" class="btn btn-sm btn-warning">Generate Cash Slip</a> 
                                @endif
                                
                                @endif   
                            @endif
                            

                            
                        </td>  
                        {{-- <td>
                            @if($item->address_outstation == 1 && !empty($item->is_invoice_raised))
                            <form action="{{ route('admin.packingslip.upload_trn') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="slip_no" value="{{ $item->slip_no }}">
                                <input type="hidden" name="order_id" value="{{ $item->order_id }}">
                                <input type="hidden" name="invoice_no" value="{{ $item->invoice_no }}">                                
                            <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" name="trn_file" class="form-control" accept="application/pdf" id="inputGroupFile04" required>
                                  <label class="" for="inputGroupFile04">Upload TRN file</label>
                                </div>
                                <div class="input-group-append">
                                  <button class="btn btn-sm btn-success" type="submit">Upload</button>
                                </div>
                            </div>                            
                            </form>

                            @if(!empty($item->trn_file))
                            <a href="{{ asset($item->trn_file) }}" target="_blank" class="btn btn-sm btn-warning">View TRN</a>
                            @endif

                            @endif
                            
                            
                        </td>                                         --}}
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @empty
                    <tr>
                        <td colspan="100%">
                            <span></span>
                        </td>
                    </tr>    
                    @endforelse
                </tbody>
            </table>    
            {{$data->links()}}           
        </div>
    </div>
    
</section>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
    })
</script>
@endsection
