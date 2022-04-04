         
@extends('layouts.newadmin')

@section('content')


    <div class="container-fluid">
    <nav class="navbar navbar-expand-md navbar-inverse navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('customer.dashboard') }}">customer <span>Dashboard</span></a>
          
            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>

                <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vendor') }}">Menu</a>
                    </li>
                </ul>
            </div>
          
            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">

            <ul class="nav navbar-nav justify-content-center">
                    <!-- Dropdown -->
                <li class="nav-item dropstart"> 
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Cart<span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                </a>

                        @php $total = 0 @endphp
                        @foreach((array) session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                        @endforeach

                <div class="dropdown-menu dropdown-menu-dark" style="width:350px">
                    <a class="dropdown-header">
                        <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                        <p class="float-right">Total: <span >Ksh.{{ $total }}</span></p>
                    </a>
                    <a><hr class="dropdown-divider"></a>
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                    <a class="dropdown-item">
                        <div class="row cart-detail">
                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                    <img src="{{ asset('storage/images/'.$details['picture']) }}" />
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                    <p>{{ $details['name'] }}</p>
                                    <span class="price text-info"> Ksh. {{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                                </div>
                        </div>
                    </a>
                        @endforeach
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                            <a href="{{ route('cart') }}" class="btn btn">View all</a>
                        </div>
                    </div>
                </div>
            </ul>


              <ul class="nav navbar-nav justify-content-center">

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                  {{ Auth::user()->first_name }}
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('customer.showupdateform') }}">Edit Profile</a>
                    <a class="dropdown-item" href="/customer/clogout">Log out</a>
                  </div>
              </ul>
            </div>
          </nav>
        <div class="container mt-5"> 
            <div class="row">
                <div class="col-lg-12 margin-tb"> 
                    <div class="float-left">
                        <h2>Details</h2>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route('cart') }}"> Back</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">{{ count((array) session('cart')) }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{ $details['name'] }}</h6>
                            <small class="text-muted">{{ $details['description'] }}</small>
                        </div>
                        <div class="col-lg-5 col-sm-5 col-5 cart-detail-img">
                            <img src="{{ asset('storage/images/'.$details['picture']) }}" />
                        </div>
                        <span class="text-muted">Ksh.{{ $details['price'] }}</span>
                    </li>
                    @endforeach
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                    <span>Total</span>
                    <strong>Ksh.{{ $total }}</strong>
                    </li>
                </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <form class="needs-validation" action="{{ route('order') }}" method="POST">
                        @csrf

                        @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                        <input type="hidden" name="counts[]" value="{{ $id }}">
                        <input type="hidden" name="vendor[]" value="{{ $details['vendor'] }}">
                        <input type="hidden" name="name[]" value="{{ $details['name'] }}">
                        <input type="hidden" name="picture[]" value="{{ $details['picture'] }}">
                        <input type="hidden" name="one_total[]" value="{{ $details['price'] * $details['quantity'] }}">
                        <input type="hidden" name="quantity[]" value="{{ $details['quantity'] }}">
                            @endforeach
                        @endif
                        <input type="hidden" name="customer" value="{{ $details['customer'] }}">
                        <input type="hidden" name="total" value="{{ $total }}">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                    <strong>First Name</strong>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First Name" value="{{ old('first_name',Auth::user()->first_name) }}" autofocus>
                                    @error('first_name')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Last Name</strong>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Last Name" value="{{ old('last_name',Auth::user()->last_name) }}" autofocus>
                                    @error('first_name')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Email</strong>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email',Auth::user()->email) }}" autofocus>
                                @error('email')
                                    <div class="text-danger mb-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <strong>Phone Number</strong>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number',Auth::user()->phone_number) }}" autofocus>
                                @error('phone_number')
                                    <div class="text-danger mb-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <strong>Address</strong>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address" value="{{ old('address') }}" autofocus>
                                @error('address')
                                    <div class="text-danger mb-3">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <strong>County</strong>
                                    <select class="form-select form-control @error('counties') is-invalid @enderror" id="county" name="county">
                                        <option value="">Select a county</option>
                                        @foreach($counties as $county) 
                                        <option value="{{ $county->id }}">{{ $county->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('county')
                                <div class="text-danger mb-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mb-4">

                        <h4 class="mb-3">Payment</h4>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="credit" name="payment" type="radio" class="custom-control-input" value="Mpesa">
                                <label class="custom-control-label" for="credit">Mpesa</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="debit" name="payment" type="radio" class="custom-control-input" value="On Delivery">
                                <label class="custom-control-label" for="debit">On Delivery</label>
                            </div>
                            @error('payment')
                            <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
@endsection