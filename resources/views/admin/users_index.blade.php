@extends('layouts.newadmin')

@section('content')

<div class="container-fluid">
@include('include.adminnav')

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Vendors</h2>
                </div>
            </div>
        </div>
    
            @if (Session::has('vendor-message'))
                <div class="alert alert-success" role="alert">
                    <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    {{ Session::get('vendor-message') }}
                </div>
            @endif

            @if (Session::has('vendor-error-message'))
                <div class="alert alert-danger" role="alert">
                    <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    {{ Session::get('vendor-error-message') }}
                </div>
            @endif

        <div class="table-responsive">
            <!--Table-->
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>County</th>
                    <th>Phone Number</th>
                    <th>Logo</th>
                    <th>Email</th>
                    <th colspan="2">Action</th>
                </tr>
                    @foreach ($vendors as $vendor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ $vendor->countiez->name }}</td>
                    <td>{{ $vendor->phone_number }}</td>
                    <td>
                        @if($vendor->logo == NULL)

                        @else
                        <img src="{{ asset('storage/images/'.$vendor->logo) }}">
                        @endif
                    </td>
                    <td>{{ $vendor->email }}</td>
                    <td>
                        <form action="{{ route('vendor.destroy',$vendor->id) }}" method="POST">
        
                            @csrf
                            @method('DELETE')
            
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>


                        @if($vendor->is_enabled == 0)

                        <form action="{{ route('vendor.enable',$vendor->id) }}" method="POST">
                            @csrf
                                <input type="hidden" value="1" name="is_enabled" id="is_enabled">
                                <input type="hidden" value="{{ $vendor->email }}" name="email" id="email">

                                <button type="submit" class="btn btn-success" value="1">Enable</a>
                        </form>      

                        @else

                        <form action="{{ route('vendor.disable',$vendor->id) }}" method="POST">
                            @csrf
                            <input type="hidden" value="0" name="is_enabled" id="is_enabled">
                            <input type="hidden" value="{{ $vendor->email }}" name="email" id="email">

                            <button type="submit" class="btn btn-danger" value="0">Disable</a>

                        </form>

                        @endif

                    </td>
                    <td>
                    <a class="btn btn-success" href="{{ route('vendor.orders',$vendor) }}">View Orders</a>
                </td>
                </tr>
                @endforeach
            </table>
        </div>

        <nav>
            Showing {{ $vendors->firstItem() }} to {{ $vendors->lastItem() }} of total {{$vendors->total()}} entries
        </nav>
        
        <div class="d-flex justify-content-center">
            {!! $vendors->appends(['customers' => $customers->currentPage()])->links() !!}
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Customers</h2>
                </div>
            </div>
        </div>
    
            @if (Session::has('customer-message'))
                <div class="alert alert-success" role="alert">
                    <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    {{ Session::get('customer-message') }}
                </div>
            @endif

            @if (Session::has('customer-error-message'))
                <div class="alert alert-danger" role="alert">
                    <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    {{ Session::get('customer-error-message') }}
                </div>
            @endif
    
        <div class="table-responsive">
            <!--Table-->
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>County</th>
                    <th>Email</th>
                    <th colspan="2">Action</th>
                </tr>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->first_name }}</td>
                    <td>{{ $customer->last_name }}</td>
                    <td>{{ $customer->phone_number }}</td>
                    <td>{{ $customer->countiez->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <form action="{{ route('customer.destroy',$customer->id) }}" method="POST">
        
                            @csrf
                            @method('DELETE')
            
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        @if($customer->is_enabled == 0)

                        <form action="{{ route('customer.enable',$customer->id) }}" method="POST">
                            @csrf
                                <input type="hidden" value="1" name="is_enabled" id="is_enabled">
                                <input type="hidden" value="{{ $customer->email }}" name="email" id="email">

                                <button type="submit" class="btn btn-success" value="1">Enable</a>
                        </form> 

                        @else
                        <form action="{{ route('customer.disable',$customer->id) }}" method="POST">
                            @csrf
                            <input type="hidden" value="0" name="is_enabled" id="is_enabled">
                            <input type="hidden" value="{{ $customer->email }}" name="email" id="email">

                            <button type="submit" class="btn btn-danger" value="0">Disable</a>

                        </form> 

                                
                        @endif

                        
                    </td>
                    <td>
                        <a class="btn btn-success" href="{{ route('customer.orders',$customer) }}">View Orders</a>
                    </td>
                </tr>
                @endforeach 
            </table>
        </div>
        <nav>
            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of total {{$customers->total()}} entries
        </nav>

        <div class="d-flex justify-content-center">
            {!! $customers->appends(['vendors' => $vendors->currentPage()])->links() !!}
        </div>
    </div>      
</div>
@endsection
