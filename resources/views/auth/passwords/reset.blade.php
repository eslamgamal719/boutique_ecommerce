@extends('layouts.app')

@section('content')

<section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">{{ __('Reset Password') }}</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
      <div class="row">
          <div class="col-6 offset-3">
              <h2 class="h5 text-uppercase mb-4">{{ __('Reset Password') }}</h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

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
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
