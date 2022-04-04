<nav class="navbar navbar-expand-md navbar-inverse navbar-dark">
                    <!-- Brand -->
                    <a class="navbar-brand" href="{{ route('vendor.dashboard') }}">
                        @if(Auth::user()->logo==NULL)
                            <img src="{{ asset('storage/images/default.png') }}" width="50" height="50" class="d-inline-block align-top" alt="">
                        @else
                            <img src="{{ asset('storage/images/'.Auth::user()->logo) }}" width="50" height="50" class="d-inline-block align-top" alt="">
                        @endif
                    </a>
                
                    <!-- Toggler/collapsibe Button -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                
                    <!-- Navbar links -->
                    <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
                        <ul class="nav navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vendor.dashboard') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('menu.index') }}">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders') }}">Orders</a>
                            </li>
                        </ul>
                    </div>
                    <!--Dropdown-->
                    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                    <ul class="nav navbar-nav nav-justified">
                        <li class="nav-item dropdown justify-content-end">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('vendor.showupdateform') }}">My account</a>
                            <a class="dropdown-item" href="/vendor/vlogout">Log out</a>
                        </div>
                        </li>
                    </ul>
                    </div>
                </nav>