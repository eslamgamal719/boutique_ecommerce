@extends('layouts.app')

@section('content')

<section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">Register</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
        </div>
      </div>
    </div>
  </section>

    <section class="py-5">
        <div class="row">
            <div class="col-6 offset-3">
                <h2 class="h5 text-uppercase mb-4">{{ __('Register') }}</h2>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="first_name" class="text-small text-uppercase">First Name</label>
                                <input type="text" name="first_name" class="form-control form-control-lg" value="{{ old('first_name') }}" placeholder="Enter first name">
                                @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="last_name" class="text-small text-uppercase">Last Name</label>
                                <input type="text" name="last_name" class="form-control form-control-lg" value="{{ old('last_name') }}" placeholder="Enter last name">
                                @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="username" class="text-small text-uppercase">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg" value="{{ old('username') }}" placeholder="Enter username">
                                @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email" class="text-small text-uppercase">Email</label>
                                <input type="text" name="email" class="form-control form-control-lg" value="{{ old('email') }}" placeholder="Enter email">
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="mobile" class="text-small text-uppercase">Mobile</label>
                                <input type="text" name="mobile" class="form-control form-control-lg" value="{{ old('mobile') }}" placeholder="Enter mobile">
                                @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password" class="text-small text-uppercase">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg" value="{{ old('password') }}" placeholder="Enter password">
                                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password_confirmation" class="text-small text-uppercase">Re-Password</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Re-type password" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Register') }}
                                </button>

                                @if(Route::has('login'))
                                    <a href="{{ route('login') }}" class="btn btn-link">
                                        {{ __('Have an account ?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection
