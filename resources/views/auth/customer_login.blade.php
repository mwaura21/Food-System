@extends('layouts.app')

@section('content')
<main class="cotainer mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <h3 class="card-header text-center">Customer Login</h3>
                <div class="card-body">

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
                    <form method="POST" action="{{ route('customer.login.submit') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" placeholder="Email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                autofocus>
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" placeholder="Password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('customer.forget.password.get') }}">Reset Password?</a>
                                      </label>
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('customer.register') }}">Create Account</a>
                                      </label>
                                  </div>
                              </div>
                          </div>

                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-dark btn-block">Sign In</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

