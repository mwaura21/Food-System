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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('myorders') }}">My Orders</a>
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
                    <a class="dropdown-item" href="{{ route('customer.showupdateform') }}" >Edit Profile</a>
                    <a class="dropdown-item" href="/customer/clogout">Log out</a>
                  </div>
              </ul>
            </div>
          </nav>