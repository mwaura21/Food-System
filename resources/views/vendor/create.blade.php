@extends('layouts.newadmin')

@section('content')

<body>
    <!--this will be the overlay that comes in small screens--> 
    <div class="container-fluid">
    @include('include.vendornav')
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-left">
                        <h2>Add New Sub Vendor</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('subvendor.index') }}"> Back</a>
                    </div>
                </div>
            </div>
        
            <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name</strong>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value= "{{ old('name') }}"autofocus>
                        </div>

                        @error('name')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email</strong>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value= "{{ old('email') }}" autofocus>
                        </div>

                        @error('email')
                            <div class="text-danger mb-3">{{ $message }}</div>
                        @enderror
                        
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            
            </form>
        </div>
    </div>
</body>
@endsection