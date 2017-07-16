@extends('layouts.admin')

@section('content')


        <h1>Api Settings</h1>

        <div class="panel-body">
            <passport-clients></passport-clients>

            <passport-authorized-clients></passport-authorized-clients>

            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>

@endsection
