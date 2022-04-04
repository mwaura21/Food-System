@extends('layouts.newadmin')

@section('content')

<body>
    <!--this will be the overlay that comes in small screens--> 
    <section>
    @include('include.vendornav')
        <body>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="float-left">
                            <h2>Sub Vendors</h2>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-success" href="{{ route('subvendor.create') }}"> Create New Sub Vendor</a>
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
                    
                <div class="table-responsive">

                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($subvendors as $subvendor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subvendor->name }}</td>
                        <td>{{ $subvendor->phone_number }}</td>
                        <td>{{ $subvendor->email }}</td>
                        <td>

                            <form action="{{ route('vendor.destroy',$subvendor->id) }}" method="POST">
                
                                <a class="btn btn-primary" href="{{ route('vendor.edit',$subvendor->id) }}">Edit</a>
            
                                @csrf
                                @method('DELETE')
                
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                            @if($vendor->is_enabled == 0)

                            <form action="{{ route('vendor.enable',$subvendor->id) }}" method="POST">
                                @csrf
                                    <input type="hidden" value="1" name="is_enabled" id="is_enabled">
                                    <input type="hidden" value="{{ $subvendor->email }}" name="email" id="email">

                                    <button type="submit" class="btn btn-success" value="1">Enable</a>
                            </form>      

                            @else

                            <form action="{{ route('vendor.disable',$subvendor->id) }}" method="POST">
                                @csrf
                                <input type="hidden" value="0" name="is_enabled" id="is_enabled">
                                <input type="hidden" value="{{ $subvendor->email }}" name="email" id="email">

                                <button type="submit" class="btn btn-danger" value="0">Disable</a>

                            </form>

                            @endif


                        </td>
                    </tr>
                    @endforeach
                </table>
            
            </div>

                <nav>
                    Showing {{ $subvendors->firstItem() }} to {{ $subvendors->lastItem() }} of total {{$subvendors->total()}} entries
                </nav>
                
                <div class="d-flex justify-content-center">
                    {!! $subvendors->links() !!}
                </div>

            </div>

        </body>
    </section>
@endsection