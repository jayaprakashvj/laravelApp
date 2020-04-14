@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}
                @if(Auth::user()->role == 'user')
                <a class="float-right" href="{{ route('home')}}">Dashboard</a>
                @else
                <a class="float-right"  href="{{ route('admin.dashboard')}}">Dashboard</a>
                @endif
                
                </div>
                @if(Session::has('msg'))
                <div class="alert alert-success" role="alert">
                {{ Session::get('msg') }}
                 </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('update.password') }}">
                        @csrf

                       

                      

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                         <ul>
                                       @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                                   @endforeach
                                          </ul>
                                    </div>
                                 @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
