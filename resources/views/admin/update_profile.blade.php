@extends('layouts.newadmin')

@section('content')

<body>
    <!--this will be the overlay that comes in small screens--> 
    <div class="container-fluid">
    @include('include.adminnav')
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12 margin-tb"> 
                    <div class="float-left">
                        <h2>Update Profile</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('admin.dashboard') }}"> Back</a>
                    </div>
                </div>
            </div>
        
                @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                        {{ Session::get('message') }}
                    </div>
                @endif

                @if (Session::has('error-message'))
                    <div class="alert alert-danger" role="alert">
                        <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                        {{ Session::get('error-message') }}
                    </div>
                @endif
                        
            <form action="{{ route('admin.updateprofile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name</strong>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name',Auth::user()->name) }}" autofocus>
                        </div>

                        @error('name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Phone Number</strong>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone Number" value="{{ old('phone_number',Auth::user()->phone_number) }}" autofocus>
                        </div>

                        @error('phone_number')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email</strong>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ Auth::user()->email }}" readonly>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>       
            </form>
        </div>
    </div>
</body>
@endsection

