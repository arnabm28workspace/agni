@extends('admin.layouts.app')
@section('page', 'Service Slip')
@section('content')
<section>
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
                        <a class="btn btn-sm btn-outline-success" href="{{ route('admin.service-slip.add') }}">Add New</a>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('admin.store.index') }}" id="searchForm">
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
                    <div class="col">                                                        
                        <div class="col-auto">
                            
                        </div>                            
                    </div>
                    <div class="col-auto">                            
                        <p>{{$total}} Items</p>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-hover ledger">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Customer</th>
                        <th>Item Name</th>
                        <th>Amount</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)                    
                    <tr>                        
                        <td>{{ date('d/m/Y', strtotime($item->entry_date)) }}</td>
                        <td>{{ $item->voucher_no }}</td>
                        <td>
                            <p class="small text-muted mb-1">
                                @if (!empty($item->store_name))
                                <span>Person Name: {{$item->store_name}}</span> <br/>
                                @endif
                                @if (!empty($item->bussiness_name))
                                <span>Company Name: {{$item->bussiness_name}}</span> <br/>
                                @endif
                                @if (!empty($item->contact))
                                <span>Phone: {{$item->contact}}</span> <br/>
                                @endif
                            </p>
                        </td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>
                            <a href="{{ route('admin.service-slip.pdf', $item->id) }}" class="btn btn-sm btn-outline-primary">PDF</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
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