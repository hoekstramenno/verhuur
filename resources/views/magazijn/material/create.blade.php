@extends('layouts.master')

@section('title')
    {{ __('All Material') }}
@endsection


@section('content')
    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    {{ __('All Material') }}
                </h1>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="content">
            <materiallist></materiallist>
        </div>
    </div>
@endsection