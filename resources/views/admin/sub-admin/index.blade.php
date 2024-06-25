@extends('admin.layouts.app')
@section('page', 'Sub Admin')
@section('content')
<section>
    <div class="row">
        <div class="col-xl-8 order-2 order-xl-1">
            <div class="card">
                <div class="card-body">

                    <div class="search__filter">
                        <div class="row align-items-center justify-content-between">
                            <div class="col">
                                
                            </div>
                            <div class="col-auto">
                                
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                {{-- <th>Published Date</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)

                            @php
                                $type = "Admin";
                                $typeClass = "primary";
                                if($item->type == 1){
                                    $type = "Admin / Partner";
                                    $typeClass = "primary";
                                }else if($item->type == 2){
                                    $type = "Accountant";
                                    $typeClass = "warning";
                                }
                            @endphp
                            <tr>
                                <td>
                                    <h6 class="text-dark">{{$item->name}}</h6>
                                    <div class="row__action">
                                        <a href="{{ route('admin.sub-admin.view', $item->id) }}">Edit</a>
                                        <a href="{{ route('admin.sub-admin.view', $item->id) }}">View</a>
                                        <a href="{{ route('admin.sub-admin.status', $item->id) }}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</a>
                                        
                                    </div>
                                </td>
                                <td>{{$item->email}}</td>
                                <td>
                                    <span class="badge bg-{{$typeClass}}">{{$type}}</span>
                                </td>
                                {{-- <td>{{date('d/m/Y', strtotime($item->created_at))}}</td> --}}
                                <td><span class="badge bg-{{($item->status == 1) ? 'success' : 'danger'}}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="small text-muted">No data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 order-1 order-xl-2">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sub-admin.store') }}" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" name="type" value="2"> --}}
                        <h4 class="page__subtitle">Add New Sub Admin</h4>
                        <div class="row">
                            <div class="col-12 col-md-6 col-xl-12">
                                <div class="form-group mb-3">
                                    <label class="label-control">Select Type <span class="text-danger">*</span> </label>
                                    <select name="type" class="form-control">
                                        <option value="" hidden selected>Select an option</option>
                                        {{-- <option value="1">Admins / Partners</option> --}}
                                        <option value="2">Accountant</option>
                                    </select>
                                    @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" placeholder="Enter name" maxlength="100" class="form-control" value="{{old('name')}}">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Email <span class="text-danger">*</span></label>
                                    <input name="email" class="form-control" placeholder="Enter email address" maxlength="200" value="{{old('email')}}">
                                    @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Password <span class="text-danger">*</span></label>
                                    <input name="password" class="form-control" placeholder="Enter password" value="{{old('password')}}">
                                    @error('password') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
