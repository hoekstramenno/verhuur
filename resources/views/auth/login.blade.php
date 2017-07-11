@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="content">
            <div class="column is-half is-offset-one-quarter">
                <h1>{{ __('Login') }}</h1>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="field ">
                        <label for="email" class="label">E-Mail Address</label>
                        <p class="control">
                            <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </p>
                    </div>

                    <div class="field ">
                        <label for="password" class="label">Password</label>

                        <p class="control">
                            <input id="password" type="password" class="input {{ $errors->has('password') ? ' has-error' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </p>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                {{ __('Remember me') }}
                            </label>

                        </div>

                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="control">
                            <a class="button is-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
