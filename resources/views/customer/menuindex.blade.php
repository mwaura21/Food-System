@extends('layouts.cart')
   
@section('content')
    
<div class="container-fluid">
@include('include.customernav')

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
          <div class="row">
          <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('vendor') }}"> Back</a>
                    </div>
                </div>
          </div>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4">
                @foreach($menus as $menu)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ asset('storage/images/'.$menu->picture) }}" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $menu->name }}</h5>
                                    <!-- Product price-->
                                    Ksh.{{ $menu->price }}
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-success" href="{{ route('add.to.cart', $menu->id) }}">Add to Cart</a></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        </div>         
    </div>
    
@endsection

