@extends('admin.layouts.app')
@section('page',  'Create Store')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Master</li>
        <li><a href="{{ route('admin.store.index') }}">Store Management</a></li>
        <li>Store Details</li>
    </ul>
    <form method="post" action="{{ route('admin.store.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group mb-3">         
                    @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="card shadow-sm">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" name="store_name" placeholder="" class="form-control" value="{{old('store_name')}}">
                                    @error('store_name') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>                    
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label class="label-control">Email</label>
                                <input type="text" name="email" placeholder="" class="form-control" value="{{old('email')}}">
                                @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="">Mobile</label>
                                <input type="text" maxlength="10" name="contact" id="contact"  placeholder="User contact" class="form-control" value="{{old('contact')}}" onkeypress="validateNum(event)">
                                @error('contact') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <input type="hidden" name="is_wa_same" id="checkWhatsappHidden" value="0">
                            <div class="form-group mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_wa_same" id="checkWhatsappSame">
                                    <label class="form-check-label" for="checkWhatsappSame">
                                      Same as Phone Number
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="">Whatsapp no <span class="text-danger">*</span></label>
                                <input type="text" maxlength="10" name="whatsapp" id="whatsapp" placeholder="User whatsapp no" class="form-control" value="{{old('whatsapp')}}" onkeypress="validateNum(event)">
                                @error('whatsapp') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card shadow-sm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="label-control">Address <span class="text-danger">*</span> </label>
                                <textarea type="text" name="address" id="address" placeholder="" class="form-control">{{old('address')}}</textarea>
                                <input type="hidden" name="lat" id="lat" value="{{old('lat')}}">
                                <input type="hidden" name="lng" id="lng" value="{{old('lng')}}">
                                @error('address') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label class="label-control">State<span class="text-danger">*</span> </label>
                                <input type="text" name="state" placeholder="" id="state" class="form-control" value="{{old('state')}}">
                                @error('state') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label class="label-control">City<span class="text-danger">*</span> </label>
                                <input type="text" name="city" placeholder="" id="city" class="form-control" value="{{old('city')}}">
                                @error('city') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label class="label-control">Pincode <span class="text-danger">*</span> </label>
                                <input type="text" name="pin" placeholder="" id="pin" class="form-control" value="{{old('pin')}}">
                                @error('pin') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>  
                    </div> 
                </div>
                <div class="card shadow-sm">
                    <div class="card-body text-end">
                        <button type="submit" class="btn btn-sm btn-success">Create </button>
                        <a href="{{ route('admin.store.index') }}" class="btn btn-sm btn-danger">Back</a>
                    </div>
                </div>
            </div>            
        </div>
    </form>
</section>
@endsection

@section('script')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I&libraries=places,geometry&callback=initMap&v=weekly"></script>
<script>
    google.maps.event.addDomListener(window,'load',initialize());
    
    function initialize(){
        console.log();
        var autocomplete= new google.maps.places.Autocomplete(document.getElementById('address'));
        google.maps.event.addListener(autocomplete, 'place_changed', function(){
            var places = autocomplete.getPlace();
            console.log(places);
            var address_details = places.address_components;
            address_details.reverse();
            $('#address').val(places.formatted_address);
            $('#lat').val(places.geometry.location.lat());
            $('#lng').val(places.geometry.location.lng());
            $('#pin').val(address_details[0].long_name);
            $('#state').val(address_details[2].long_name);
            $('#city').val(address_details[4].long_name);
        
        });
    }
    
    function validateNum(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
        // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
    $("input:checkbox#checkWhatsappSame").change(function() {
        var ischecked= $(this).is(':checked');
        var contact = $('#contact').val();
        var whatsapp = $('#whatsapp').val();  
        var checkWhatsappHidden = $('#checkWhatsappHidden').val();      

        if(ischecked){
            $('#whatsapp').val(contact);    
            $('#checkWhatsappHidden').val(1);       
        }else{
            $('#whatsapp').val('');     
            $('#checkWhatsappHidden').val(0);       
        }       
    });
</script>
@endsection
