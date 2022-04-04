@extends('layouts.newadmin')

@section('content')

<div class="container-fluid">
        <nav class="navbar navbar-expand-md navbar-inverse navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="#">
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
            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
              <ul class="nav navbar-nav justify-content-center">

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                  {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('subvendor.showupdateform') }}" >Edit Profile</a>
                    <a class="dropdown-item" href="/subvendor/logout">Log out</a>
                  </div>
              </ul>
            </div>
          </nav>
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
          <div class="container-fluid admin-container row">
            <div class="col-md-6">
                <a href="#" class="btn btn-outline-light" role="button">Menu
                    <span><img src="{{ asset('storage/images/menu-icon.jpg') }}" alt=""></span>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route(sub'vendor.showupdateform') }}" class="btn btn-outline-light" role="button">My account
                    <span><img src="{{ asset('storage/images/Messages-icon.jpg') }}" alt=""></span>
                </a>
            </div>
        </div>
          
    </div>
@endsection
