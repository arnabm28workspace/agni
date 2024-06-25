@extends('admin.layouts.app')
@section('page', 'Customer Management')
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
                        <a class="btn btn-sm btn-outline-success" href="{{ route('admin.store.create') }}">Add New Customer</a>
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
            <form action="{{ route('admin.store.bulkSuspend') }}" method="POST">
            @csrf    
            <div class="filter">
                <div class="row align-items-center justify-content-between">
                    <div class="col">                                                        
                        <div class="col-auto">
                            <button id="btnSuspend" type="submit" class="btn btn-outline-danger btn-sm">Suspend</button>
                        </div>                            
                    </div>
                    <div class="col-auto">                            
                        <p>{{$total}} Items</p>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="check-column">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkAll">
                            </div>
                        </th>
                        <th>Created At</th>
                        <th>Created From</th>
                        <th>Person Name</th>
                        <th>Company Name</th>
                        <th>Contact</th>
                        <th width="240px">Address</th>
                        <th>Status</th>
                        <th>Approved</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)

                    @php
                        $created_from = "Admin / Partner";
                        if($item->created_from == 'staff'){
                            $created_by = $item->created_by;
                            $staff = DB::table('users')->find($created_by);
                            $created_from = $staff->name;
                        }
                          
                    @endphp
                    <tr>
                        <td class="check-column">
                            @if ($item->status == 1)
                            <div class="form-check">
                                <input name="suspend_check[]" class="data-check" type="checkbox"  value="{{$item->id}}">
                            </div>
                            @endif
                        </td>
                        <td>
                            {{ date('d/m/Y', strtotime($item->created_at)) }}
                            <div class="row__action">
                                <a href="{{ route('admin.store.edit', $item->id) }}">Edit</a>
                                <a href="{{ route('admin.store.view', $item->id) }}">View</a>
                                <a href="{{ route('admin.invoice.store', $item->id) }}">Invoices</a>
                                <a href="{{ route('admin.store.status', $item->id) }}">{{($item->status == 1) ? 'Suspend' : 'Active'}}</a>
                                @if (empty($item->is_approved))
                                <a href="{{ route('admin.store.approve', $item->id) }}" onclick="return confirm('Are you sure want to approve the store?');">Approve</a>
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ ucwords($created_from) }}
                        </td>
                        <td>
                        {{$item->store_name}}                        
                        </td>
                        <td>{{ $item->bussiness_name }}</td>
                        <td>
                            <p class="small text-muted mb-1"> 
                                @if(!empty($item->contact))
                                <span>Mobile: <strong>{{$item->contact}}</strong></span> <br/>
                                @endif
                                @if (!empty($item->whatsapp))
                                <span>WhatsApp: <strong> {{$item->whatsapp}}</strong></span>  <br/>
                                @endif   
                                @if (!empty($item->email))
                                <span>Email ID: <strong> {{$item->email}}</strong></span>  <br/>
                                @endif                                
                            </p>
                           
                        </td>
                        <td>{{$item->billing_address}}<br>{{$item->billing_city}}<br>{{$item->billing_state}}</td>
                        <td>
                            @if (!empty($item->status))
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Suspended</span>
                            @endif
                        </td>
                        <td>
                            @if (!empty($item->is_approved))
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Not Approved</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                    @endforelse
                </tbody>
            </table>  
            </form>
            {{$data->links()}}
        </div>       
    </div>
</section>
<script>

    $(document).ready(function(){
        $('#btnSuspend').prop('disabled', true);
        
        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            var checkAllStatus = $("#checkAll:checked").length;
            var total_checkbox = $('input:checkbox.data-check').length;
            console.log(total_checkbox)
            if(checkAllStatus == 1 && total_checkbox > 0){
                $('#btnSuspend').prop('disabled', false);
            }else{
                $('#btnSuspend').prop('disabled', true);
            }
        });

        $('.data-check').change(function () {
            $('#btnSuspend').prop('disabled', false);
            var total_checkbox = $('input:checkbox.data-check').length;
            var total_checked = $('input:checkbox.data-check:checked').length;
            // console.log( total_checkbox);
            // console.log(total_checked);

            if(total_checked == 0){
                $('#btnSuspend').prop('disabled', true);
            }
          
            if(total_checkbox == total_checked){
                console.log('All checked')
                $('#checkAll').prop('checked', true);
            }else{
                console.log('Not All checked')
                $('#checkAll').prop('checked', false);
            }
        })
        
    });

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

{{-- google location section --}}
@section('script')
{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I&libraries=places,geometry&callback=initMap&v=weekly"></script> --}}
<script>
    // google.maps.event.addDomListener(window,'load',initialize());
    
    // function initialize(){
    //     console.log();
    //     var autocomplete= new google.maps.places.Autocomplete(document.getElementById('address'));
    //     google.maps.event.addListener(autocomplete, 'place_changed', function(){
    //         var places = autocomplete.getPlace();
    //         console.log(places);
    //         var address_details = places.address_components;
    //         address_details.reverse();
    //         $('#address').val(places.formatted_address);
    //         $('#lat').val(places.geometry.location.lat());
    //         $('#lng').val(places.geometry.location.lng());
    //         $('#pin').val(address_details[0].long_name);
    //         $('#state').val(address_details[2].long_name);
    //         $('#city').val(address_details[4].long_name);
        
    //     });
    // }

    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
    })
</script>
@endsection