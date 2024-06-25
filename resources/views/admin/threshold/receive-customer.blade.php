@extends('admin.layouts.app')
@section('page', 'Place Order')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Sales</li>
        <li><a href="{{ route('admin.product.thresholdRequest') }}">Price Requests</a> </li>
        <li>Place Order</li>
    </ul>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">                    
                    <div class="admin__content">
                        <aside>
                            <nav>Information</nav>
                        </aside>
                        <content>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Requested From</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">{{ $data->user_name }}</p>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Customer</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">{{ $data->store_name }}</p>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Product</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">{{ $data->pro_name }}</p>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="inputPassword6" class="col-form-label">Outstanding Price (Pcs per Ctn)</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">{{ 'Rs. '.number_format((float)$data->sell_price, 2, '.', '') }} ({{$data->pcs}})</p>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">No of Ctns</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">{{ $data->qty }}</p>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="inputPassword6" class="col-form-label">Requested Price</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">{{ 'Rs. '.number_format((float)$data->price, 2, '.', '') }}</p>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Requested At</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">{{ date('d/m/Y H:i A', strtotime($data->created_at)) }}</p>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Request Status</label>
                                </div>
                                <div class="col-9">
                                    <p class="m-0">Approved</p>
                                </div>
                            </div>
                        </content>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.saveRequestedPriceReceiveOrder') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                        <h4>Place order</h4>
                        <input type="hidden" name="customer_approval" value="1">
                        {{-- <h6>Approve / Deny </h6>
                        <div class="form-group mb-3">  
                            <select name="customer_approval" class="form-control" id="">
                                <option value="">Choose an option</option>
                                <option value="1">Approve</option>
                                <option value="2">Deny</option>
                            </select>
                            @error('customer_approval') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div> --}}
                        <div class="form-group mb-3">  
                            <textarea name="customer_approve_note" placeholder="Enter some note" rows="5" class="form-control"></textarea>
                            @error('customer_approve_note') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="form-group">
                            <a href="{{ route('admin.product.thresholdRequest') }}" class="btn btn-sm btn-danger">Back</a>
                            <button type="submit" class="btn btn-sm btn-success">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
