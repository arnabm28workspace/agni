@extends('admin.layouts.app')
@section('page', 'Service Slip')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Master</li>      
        <li><a href="{{route('admin.service-slip.index')}}">Service Slip</a></li>      
        <li>Add</li>
    </ul>       
    <div class="row">
        <div class="col-sm-12">
            {{-- @if($errors->any())                     
                {!! implode('', $errors->all('<p class="small text-danger">:message</p>')) !!}
            @endif --}}
            @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
            @endif
            
            <form id="myForm" action="{{ route('admin.service-slip.save') }}" method="POST">
                @csrf        
                @php
                    $voucher_no = "SERVICE".time();                                       
                @endphp        
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group mb-3">
                            <label for="">Voucher No</label>
                            <input type="text" value="@if (!empty(old('voucher_no'))) {{old('voucher_no')}} @else {{$voucher_no}} @endif" name="voucher_no" readonly id="voucher_no" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mb-3">
                            <label for="" id="lable_user">Customer</label> <span class="text-danger">*</span>
                            
                            <input type="hidden" name="store_id" id="store_id" value="{{ old('store_id') }}">
                            <input type="text" name="" value="{{ old('user_name') }}"  class="form-control"  id="select_user_name" onkeyup="getUsers(this.value);" placeholder="Search customer ... ">                            
                            @error('user_name') <p class="small text-danger ">{{ $message }}</p> @enderror
                            @error('store_id') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="respDrop"></div>
                    </div>   
                    
                    <div class="col-sm-3">
                        <div class="form-group mb-3">
                            <label for="">Amount <span class="text-danger">*</span></label>
                            <input type="text" id="amount" value="{{ old('amount') }}" pattern="^\d*(\.\d{0,2})?$"  maxlength="10" name="amount" class="form-control" onkeypress="validateNum(event)"  placeholder="Enter amount ... ">
                            @error('amount') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>                  
                    <div class="col-sm-3">
                        <div class="form-group mb-3">
                            <label for="">Date <span class="text-danger">*</span></label>
                            <input type="date" name="entry_date" id="entry_date" class="form-control" value="{{ old('entry_date') }}"  autocomplete="off" max="{{ date('Y-m-d')}}">
                            @error('entry_date') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div> 
                </div>  

                
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Enter item name">
                            @error('item_name') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>  
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="">Narration</label>
                            <textarea name="narration" class="form-control" style="" id="" cols="5" rows="5" placeholder="Enter some text ... ">{{ old('narration') }}</textarea>
                        </div>
                    </div>                    
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <a href="{{ route('admin.service-slip.index') }}" class="btn btn-sm btn-danger">Back</a>
                        <button id="submitBtn" type="submit" class="btn btn-sm btn-success">Add</button>
                    </div>
                </div>
            </form>
        </div> 
    </div>    
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
    });

    function getUsers(evt){
        var user_type = $('#user_type').val();
        if(evt.length > 0){
            console.log(evt);
            $.ajax({
                url: "{{ route('admin.ledger.getUsersByType') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    term: evt,
                    type: 'store'
                },
                success: function(result) {

                    console.log(result);
                    var content = '';
                    if (result.length > 0) {
                        content += `<div class="dropdown-menu show w-100 user-dropdown" aria-labelledby="dropdownMenuButton">`;

                        $.each(result, (key, value) => {
                            content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value.id},'${value.name}')">${value.name}</a>`;
                        })
                        content += `</div>`;
                        // $($this).parent().after(content);
                    } else {
                        content += `<div class="dropdown-menu show w-100 user-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">No user found</li></div>`;
                    }
                    $('.respDrop').html(content);
                }
            });
        }else{
            $('.respDrop').text('');
        }
    }

    function fetchCode(id,name) {
        $('.user-dropdown').hide()
        $('#select_user_name').val(name) 
        $('#store_id').val(id)
    }
</script>      
@endsection
