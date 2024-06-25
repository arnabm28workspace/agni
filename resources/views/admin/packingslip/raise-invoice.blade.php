@extends('admin.layouts.app')
@section('page', 'Raise Invoice')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Sales</li>
        <li><a href="{{ route('admin.packingslip.index') }}">Packing Slips</a></li>
        <li>Raise Invoice</li>
    </ul>     
    <div class="row">
        <div class="col-sm-12">       
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            @php
                $gstText = "GST";
                
                if($data[0]->is_gst == 0){
                    $gstText = "NON-GST";
                }
            @endphp

            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Order No:- <span>{{ $data[0]->order_no }} <strong>{{$gstText}}</strong> </span></h6>
                    <h6>Slip No:- <span>{{ $data[0]->slip_no }}</span></h6>      
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <h6>Customer Details</h6>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="small m-0">
                                            <strong>Person Name :</strong> 
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="small m-0">
                                            {{$data[0]->store_name}}
                                        </p>
                                    </div>
                                </div>
                                @if (!empty($data[0]->bussiness_name))
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="small m-0">
                                            <strong>Company Name :</strong> 
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="small m-0">
                                            {{$data[0]->bussiness_name}}
                                        </p>
                                    </div>
                                </div>    
                                @endif                               
                                @if (!empty($data[0]->store_email))
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="small m-0">
                                            <strong>Email ID :</strong> 
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="small m-0">
                                            {{$data[0]->store_email}}
                                        </p>
                                    </div>
                                </div>    
                                @endif
                                @if (!empty($data[0]->store_contact))
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="small m-0">
                                            <strong>Mobile No :</strong> 
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="small m-0">
                                            {{$data[0]->store_contact}}
                                        </p>
                                    </div>
                                </div>   
                                @endif                               
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="small m-0">
                                            <strong>WhatsApp No :</strong> 
                                        </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="small m-0">
                                            {{$data[0]->store_whatsapp}}
                                        </p>
                                    </div>
                                </div>              
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h6>
                                Billing Address
                                @if (!empty($data[0]->address_outstation))
                                    <span>(Outstation)</span>
                                @endif
                            </h6>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>Address :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_billing_address}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>Landmark :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_billing_landmark}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>State :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_billing_state}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>City :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_billing_city}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>Pin Code :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_billing_pin}}
                                    </p>
                                </div>
                            </div>                            
                        </div>
                        <div class="col-sm-4">
                            <h6>
                                Shipping Address
                                @if (!empty($data[0]->address_outstation))
                                    <span>(Outstation)</span>
                                @endif
                            </h6>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>Address :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_shipping_address}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>Landmark :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_shipping_landmark}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>State :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_shipping_state}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>City :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_shipping_city}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="small m-0">
                                        <strong>Pin Code :</strong> 
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="small m-0">
                                        {{$data[0]->store_shipping_pin}}
                                    </p>
                                </div>
                            </div>                             
                        </div>
                    </div>
                </div>
            </div>
            <form id="myForm" action="{{ route('admin.packingslip.save_invoice') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="store_id" value="{{ $data[0]->store_id }}">
            <input type="hidden" name="user_id" value="{{ $data[0]->user_id }}">
            <input type="hidden" name="order_no" value="{{ $data[0]->order_no }}">
            <input type="hidden" name="slip_no" value="{{ $data[0]->slip_no }}">
            <input type="hidden" name="order_id" value="{{ $data[0]->order_id }}">
            <input type="hidden" id="is_gst" name="is_gst" value="{{$data[0]->is_gst}}">

            {{-- store personal info --}}
            <input type="hidden" name="store_name" value="{{ $data[0]->store_name }}">
            <input type="hidden" name="store_whatsapp" value="{{ $data[0]->store_whatsapp }}">
            <input type="hidden" name="store_contact" value="{{ $data[0]->store_contact }}">

            {{-- store address info --}}
            <input type="hidden" name="store_billing_address" value="{{ $data[0]->store_billing_address}}">
            <input type="hidden" name="store_billing_latitude" value="">
            <input type="hidden" name="store_billing_longitude" value="">
            <input type="hidden" name="store_billing_landmark" value="{{ $data[0]->store_billing_landmark}}">
            <input type="hidden" name="store_billing_state" value="{{ $data[0]->store_billing_state}}">
            <input type="hidden" name="store_billing_city" value="{{ $data[0]->store_billing_city}}">
            <input type="hidden" name="store_billing_pin" value="{{ $data[0]->store_billing_pin}}">
            <input type="hidden" name="store_shipping_address" value="{{ $data[0]->store_shipping_address}}">
            <input type="hidden" name="store_shipping_longitude" value="">
            <input type="hidden" name="store_shipping_latitude" value="">
            <input type="hidden" name="store_shipping_landmark" value="{{ $data[0]->store_shipping_landmark}}">
            <input type="hidden" name="store_shipping_state" value="{{ $data[0]->store_shipping_state}}">
            <input type="hidden" name="store_shipping_city" value="{{ $data[0]->store_shipping_city}}">
            <input type="hidden" name="store_shipping_pin" value="{{ $data[0]->store_shipping_pin}}">
            <input type="hidden" name="store_address_outstation" value="{{ $data[0]->address_outstation }}">
            @php
                $net_price = 0;
            @endphp   
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Total Ctns</th>
                        <th>Total Pcs</th>
                        <th>Price per Piece (Exc.Tax)</th>
                        <th>Total Amount (Exc.Tax)</th>
                        <th>HSN Code</th>
                        @if (!empty($data[0]->address_outstation))
                        <th>IGST</th>   
                        @else
                        <th>CGST</th> 
                        <th>SGST</th>
                        @endif
                        <th>Total Amount (Inc.Tax)</th>                        
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @forelse ($data as $item)
                        
                    @php
                        if(!empty($data[0]->address_outstation)){
                            $gst_val = $item->igst;
                        } else {
                            $gst_val = ($item->cgst + $item->sgst);
                        }
                        


                        $getOrderProductDetails = getOrderProductDetails($item->order_id,$item->product_id);
                        // $single_product_price = $getOrderProductDetails->price;
                        $single_product_price = $getOrderProductDetails->piece_price;
                        $product_qty = $getOrderProductDetails->qty;
                        
                        $getGSTAmount_single_product_price = getGSTAmount($single_product_price,$item->igst);
                        $single_pro_gst_amount = $getGSTAmount_single_product_price['gst_amount'];
                        $single_pro_net_amount = $getGSTAmount_single_product_price['net_price'];
                        
                        $total_price =  ( $single_pro_net_amount * $item->pcs );
                        
                        $gst_calculation = getPercentageVal($gst_val,$total_price);
                        $product_gst_price = ($total_price + $gst_calculation);
                                                
                        $net_price += $product_gst_price;
                    @endphp
                    <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                    <input type="hidden" name="product_name[]" value="{{$item->pro_name}}">
                    <input type="hidden" name="is_store_address_outstation[]" value="{{$data[0]->address_outstation}}">
                    <input type="hidden" name="igst[]" value="{{$item->igst}}">
                    <input type="hidden" name="cgst[]" value="{{$item->cgst}}">
                    <input type="hidden" name="sgst[]" value="{{$item->sgst}}">
                    <tr>   
                        <td>{{$i}}</td>                     
                        <td>{{ $item->pro_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->pcs }}</td>
                        <input type="hidden" name="quantity[]" value="{{$item->quantity}}">
                        <input type="hidden" name="pcs[]" value="{{$item->pcs}}">
                        <td>Rs. {{ number_format((float)$single_pro_net_amount, 2, '.', '') }}</td>
                        <input type="hidden" name="price[]" value="{{ number_format((float)$single_pro_net_amount, 2, '.', '') }}">
                        <input type="hidden" name="single_product_price[]" value="{{ number_format((float)$single_product_price, 2, '.', '') }}">
                        <td>Rs. {{ number_format((float)$total_price, 2, '.', '') }}</td>
                        <input type="hidden" name="count_price[]" value="{{ number_format((float)$total_price, 2, '.', '') }}">
                        <td>{{ $item->hsn_code }}</td>
                        <input type="hidden" name="hsn_code[]" value="{{$item->hsn_code}}">
                        @if (!empty($data[0]->address_outstation))
                            <td>{{$item->igst}} % </td>
                        @else
                            <td>{{$item->cgst}} % </td>
                            <td>{{$item->sgst}} % </td>
                        @endif
                        <td>Rs. {{ number_format((float)$product_gst_price, 2, '.', '') }}</td>
                        <input type="hidden" name="total_price[]" value="{{$product_gst_price}}">                           
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @empty
                        
                    @endforelse
                    
                </tbody>
                
            </table>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">                            
                            <h6>Total Invoice Amount (Inc. Tax) :- Rs. {{ number_format((float)$net_price, 2, '.', '') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="address_outstation" id="acknowledgement">
                                    <label class="form-check-label" for="acknowledgement">
                                        As per the Indian IT Act, an electronic document requires an electronic signature as prescribed by the Act, to gain legal sanctity in the court of law. Hence saying that the printed document in the subject is produced electronically and therefore does not require a signature is not acceptable.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($data[0]->address_outstation)     
            {{-- <div class="row">
                <div class="col-sm-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Upload TRN (Store Address Outstation)
                            <span class="text-danger">*</span>
                        </div>
                        <div class="card-body">
                            <div class="w-100 product__thumb">
                            <label for="thumbnail"><img id="output" src="{{ asset('admin/images/placeholder-image.jpg') }}"/></label>
                            @error('trn_file') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            <input type="hidden" name="is_trn_file_uploaded" value="0" id="is_trn_file_uploaded">
                            <input type="file" id="thumbnail" accept="image/*" name="trn_file" onchange="loadFile(event)" class="d-none" >
                            <script>
                            var loadFile = function(event) {
                                var output = document.getElementById('output');
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
                                    URL.revokeObjectURL(output.src) // free memory
                                }
        
                                $('#is_trn_file_uploaded').val(1);
                            };
                            </script>
                        </div>
                    </div>     
                </div>
            </div>        --}}
              
            @endif
            <input type="hidden" name="net_price" value="{{$net_price}}">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="{{ route('admin.packingslip.index') }}" class="btn btn-sm btn-danger">Back</a>
                    <button type="submit" id="submitBtn" class="btn btn-sm btn-success"> Generate Invoice</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    
</section>
@endsection

@section('script')
    <script>
        $("[type='number']").keypress(function (evt) {
            evt.preventDefault();
        });

        $(document).ready(function(){
            var is_gst = $('#is_gst').val();
            if(is_gst == 0){
                $('#myForm').submit();
            }
            $('#submitBtn').prop('disabled', true);
        })

        $('#acknowledgement').change(function(){
            var isCheck = $("#acknowledgement:checked").length;
            // alert(isCheck)
            if(isCheck == 1) {
                $('#submitBtn').prop('disabled', false);
            } else {
                $('#submitBtn').prop('disabled', true);
            }
        })

        
    </script>
@endsection
