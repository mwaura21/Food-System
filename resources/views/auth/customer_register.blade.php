@extends('layouts.app')

@section('content')
<main class="cotainer mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <h3 class="card-header text-center">Customer Register</h3>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.register.submit') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <input type="text" placeholder="First Name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required
                                autofocus>
                            @error('first_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" placeholder="Last Name" id="lsst_name" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required
                                autofocus>
                            @error('last_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" placeholder="Phone Number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required
                                autofocus>
                            @error('phone_number')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <select class="form-select form-select-lg mb-3 @error('counties') is-invalid @enderror" id="counties" name="counties">
                                <option value="">Select a county</option>
                                @foreach($counties as $county) 
                                <option value="{{ $county->id }}">{{ $county->name }}</option>
                                @endforeach
                            </select>
                                @error('counties')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                        </div>

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

                        <div class="form-group mb-3">
                            <input type="password" placeholder="Confirm Password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                              <div class="col-md-6 offset-md-6">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('customer.login') }}">Login</a>
                                      </label>
                                  </div>
                              </div>
                          </div>
                        
                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-dark btn-block">Sign Up</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

