@extends('layouts.app')

@section('content')
<main class="cotainer mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <h3 class="card-header text-center">Vendor Register</h3>
                <div class="card-body">
                    <form method="POST" action="{{ route('vendor.register.submit') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <input type="text" placeholder="Name" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required
                                autofocus>
                            @error('name')
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
                            <input type="text" placeholder="Email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                autofocus>
                            @error('email')
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
                                          <a href="{{ route('vendor.login') }}">Login</a>
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

