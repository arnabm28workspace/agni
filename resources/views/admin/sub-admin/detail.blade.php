@extends('admin.layouts.app')
@section('page', 'Detail')
@section('content')
<section>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- {{ dd($data[0]) }} --}}
                            <h3>{{ $data[0]->name }}</h3>
                            <p class="small">{{ $data[0]->email }}</p>
                            <hr>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                    <hr>

                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sub-admin.update', $data[0]->id) }}" enctype="multipart/form-data">@csrf
                    {{-- {{ dd($data[0]) }} --}}

                        <h4 class="page__subtitle">Edit</h4>
                        <div class="form-group mb-3">
                            <label class="label-control">Type <span class="text-danger">*</span> </label>
                            <select name="type" disabled class="form-control" id="">
                                <option value="">Select an option</option>
                                <option value="1" @if($data[0]->type == '1') selected @endif>Admins / Partners</option>
                                <option value="2" @if($data[0]->type == '2') selected @endif>Accountant</option>
                                <option value="3" @if($data[0]->type == '3') selected @endif>Staff</option>
                                <option value="4" @if($data[0]->type == '4') selected @endif>Manager</option>
                            </select>
                            @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Name <span class="text-danger">*</span> </label>
                            <input type="text" name="name" placeholder="Enter name" maxlength="100" class="form-control" value="{{ $data[0]->name }}">
                            @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Email </label>
                            <input name="email" class="form-control" placeholder="Enter email address" maxlength="200" value="{{ $data[0]->email }}">
                            @error('email') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label class="label-control">Password </label>
                            <input name="password" class="form-control" value="">
                            @error('password') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div> --}}

                        {{-- </div> --}}
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{ $data[0]->id }}">
                            {{-- <input type="hidden" name="type" value="2"> --}}
                            <a href="{{ route('admin.sub-admin.index') }}" class="btn btn-sm btn-danger">Back</a>
                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
