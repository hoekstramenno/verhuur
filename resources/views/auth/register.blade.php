@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="content">
            <div class="column is-half is-offset-one-quarter">

                <h1>{{ __('Register') }}</h1>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="field">
                        <label for="name" class="label">Name</label>

                            <input id="name" type="text" class="{{ $errors->has('name') ? ' has-error' : '' }} input" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif

                    </div>

                    <div class="field">
                        <label for="email" class="label">E-Mail Address</label>


                            <input id="email" type="email" class="input {{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                    </div>

                    <div class="field">
                        <label for="password" class="label">Password</label>


                            <input id="password" type="password" class="input {{ $errors->has('password') ? ' has-error' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif

                    </div>

                    <div class="field">
                        <label for="password-confirm" class="label">Confirm Password</label>


                            <input id="password-confirm" type="password" class="input" name="password_confirmation" required>

                    </div>

                    <div class="field">
                        <div class="control">
                            <button type="submit" class="button is-primary">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
