@extends('admin.layouts.app')
@section('page', 'Add Payment Receipt')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li><a href="{{ route('admin.paymentcollection.index') }}">Payment Collection</a></li>
        <li>Add Payment Receipt</li>
    </ul>
    <div class="row">
        @php
            $readonly = "readonly";
            if(empty($payment_collection)){
                $readonly = "";
            }
        @endphp
        <div class="col-md-12">
            {{-- @if($errors->any())                     
                {!! implode('', $errors->all('<p class="small text-danger">:message</p>')) !!}
            @endif             --}}
            @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
            @endif
            <form id="payment_form" action="{{ route('admin.accounting.save_payment_receipt') }}" method="POST">
                @csrf   
                <input type="hidden" name="payment_collection_id" value="{{$paymentCollectionId}}">             
                <div class="row">                    
                    <div class="col-sm-4">                        
                        <div class="form-group mb-3">
                            <label for="" id="">Store <span class="text-danger">*</span></label>
                            @if (!empty($payment_collection))
                            <input type="hidden" name="store_id" value="{{ $payment_collection->store_id }}">
                            <input type="text" name="" value="{{ $payment_collection->store_name }}" class="form-control"  id="store_name" {{$readonly}}>
                            @else
                            <select name="store_id" class="form-control" id="">
                                <option value="" hidden selected> Select an option </option>
                                @forelse ($stores as $store)
                                <option value="{{$store->id}}" @if(old('store_id') == $store->id) selected @endif>{{$store->store_name}}</option>
                                @empty
                                <option value="">No store found ... </option>  
                                @endforelse
                            </select>
                                
                            @endif
                            @error('store_id') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>  
                   
                    <div class="col-sm-4">                        
                        <div class="form-group mb-3">
                            <label for="" id="">Collected By </label>
                            @if (!empty($payment_collection))
                            <input type="hidden" name="staff_id" value="{{ $payment_collection->user_id }}">
                            <input type="text" name="" value="{{ $payment_collection->staff_name }}" class="form-control"  id="" {{$readonly}}>  
                            @else
                            <input type="hidden" name="staff_id" value="{{ Auth::user()->id }}">
                            <input type="text" name="" value="{{ Auth::user()->name }}" class="form-control"  id="" readonly>  
                            @endif
                            
                        </div>
                    </div>    
                    
                                        
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Amount <span class="text-danger">*</span></label>
                            @if (!empty($payment_collection))
                            <input type="text" value="{{ $payment_collection->collection_amount }}" maxlength="20" name="amount" {{$readonly}} class="form-control">
                            @else
                            <input type="text" value="{{ old('amount') }}" maxlength="20" name="amount" class="form-control">
                            @endif
                            
                            @error('amount') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Voucher No</label>
                            <input type="text" value="@if (!empty(old('voucher_no'))) {{old('voucher_no')}} @else {{'PAYRECEIPT'.time()}} @endif" name="voucher_no" {{$readonly}} class="form-control">
                        </div>
                    </div>
                    @php                        
                        // $paymentDate = !empty($payment_collection)?$payment_collection->cheque_date:'';
                    @endphp
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="">Date <span class="text-danger">*</span></label>
                            @if (!empty($payment_collection))
                            <input type="date" name="payment_date" id="payment_date" max="{{date('Y-m-d')}}" class="form-control" value="{{ $payment_collection->cheque_date }}"  {{$readonly}}>
                            @else
                            <input type="date" name="payment_date" id="payment_date" max="{{date('Y-m-d')}}" class="form-control" value="{{ old('payment_date') }}"  {{$readonly}}>
                            @endif
                            
                            @error('payment_date') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div> 
                    <div class="col-sm-4">
                        @if (!empty($payment_collection))
                        <input type="hidden" name="payment_mode" value="{{ $payment_collection->payment_type }}">
                        @endif
                        
                        <div class="form-group mb-3">
                            <label for="">Mode of Payment <span class="text-danger">*</span></label>
                            <select name="payment_mode" class="form-control" @if(!empty($payment_collection)) disabled @endif  id="payment_mode">
                                <option value="" selected hidden>Select One</option>
                                @if (!empty($payment_collection))
                                <option value="cheque" @if($payment_collection->payment_type == 'cheque') selected @endif>Cheque</option>
                                <option value="neft" @if($payment_collection->payment_type == 'neft') selected @endif>NEFT</option>
                                <option value="cash" @if($payment_collection->payment_type == 'cash') selected @endif>Cash</option>
                                @else
                                <option value="cheque" @if(old('payment_mode') == 'cheque') selected @endif>Cheque</option>
                                <option value="neft" @if(old('payment_mode') == 'neft') selected @endif>NEFT</option>
                                <option value="cash" @if(old('payment_mode') == 'cash') selected @endif>Cash</option>  
                                @endif
                                
                            </select>
                            @error('payment_mode') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="row" id="noncash_sec">                    
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="">Cheque No / UTR No </label>
                            @if (!empty($payment_collection))
                            <input type="text" {{$readonly}} value="{{ $payment_collection->cheque_number }}" name="chq_utr_no" class="form-control" maxlength="100">
                            @else
                            <input type="text" {{$readonly}} value="{{ old('chq_utr_no') }}" name="chq_utr_no" class="form-control" maxlength="100">
                            @endif
                            
                            @error('chq_utr_no') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="">Bank Name </label>
                            <div id="bank_search">
                                @if (!empty($payment_collection))
                                <input type="text" id="" value="{{ $payment_collection->bank_name }}" name="bank_name" {{$readonly}} class="form-control" maxlength="200">
                                
                                @else
                                <input type="text" id="" placeholder="Search Bank" name="bank_name" value="{{ old('bank_name') }}" onkeyup="getBankList(this.value);" class="form-control bank_name" maxlength="200">
                                <input type="hidden" class="form-control"  name="bank_name_hidden" value="{{ old('bank_name') }}"  id="bank_name">
                                <div class="resBankProp"></div>
                                @endif
                                
                            </div>                                                      
                        </div>
                    </div>                    
                </div>
                         
                <div class="row">
                    <div class="form-group">
                        <a href="{{ route('admin.paymentcollection.index') }}" class="btn btn-sm btn-danger">Back</a>
                        <button type="submit" id="submit_btn" class="btn btn-sm btn-success">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>

    $(document).ready(function(){
        
        var paymentCollectionId = "{{$paymentCollectionId}}";
        // alert(paymentCollectionId);
        if(paymentCollectionId == 0){            
            var payment_mode = "{{ old('payment_mode') }}";
            console.log(payment_mode);
            if(payment_mode == ""){                
                $('#noncash_sec').hide();
            }else {
                if(payment_mode == 'cash'){
                    $('#noncash_sec').hide();
                } else {
                    $('#noncash_sec').show();
                }
            }
        }else{
            // alert(paymentCollectionId);
            $('#noncash_sec').show();
        }
        
        
    })
    
    $("#payment_form").submit(function() {
        // $('input').attr('disabled', 'disabled');
        $('#submit_btn').attr('disabled', 'disabled');
        return true;
    });

    $('#payment_mode').on('change', function(){
        console.log(this.value);
        if(this.value == 'cash'){
            $('#noncash_sec').hide();
        }else{
            $('#noncash_sec').show();
        }
    });

    function getBankList(evt)
    {
        
        if(evt.length > 0){
            // console.log(evt);
            $.ajax({
                url: "{{ route('admin.ledger.getBankList') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    term: evt
                },
                success: function(result) {

                    // console.log(result);
                    var content = '';
                    if (result.length > 0) {
                        content += `<div class="dropdown-menu show w-100 bankname-dropdown" aria-labelledby="dropdownMenuButton">`;

                        $.each(result, (key, value) => {
                            content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchBankName('${value.name}')">${value.name}</a>`;
                        })
                        content += `</div>`;
                        // $($this).parent().after(content);
                    } else {
                        content += `<div class="dropdown-menu show w-100 bankname-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">No bank found</li></div>`;
                    }
                    $('.resBankProp').html(content);
                }
            });
        }else{
            $('.resBankProp').text('');
            
        }
    }

    function fetchBankName(name)
    {
        if(name != ' - OTHERS -'){
            $('.bankname-dropdown').hide();           
            $('input[name="bank_name"]').val(name)
            $('input[name="bank_name_hidden"').val(name)
        }else{
            $('#bank_search').hide();
            $('#bank_custom').show();
        }
        
    }  

</script>
@endsection
