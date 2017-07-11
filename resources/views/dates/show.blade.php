@extends('layouts.master')

@section('title')
    {{ $date->getStatusLabel() }}: {{ $date->formatted_from_date }} - {{ $date->formatted_to_date }}
@endsection


@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-half is-offset-one-quarter">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            {{ $date->getStatusLabel() }}: {{ __('Option') }} {{ $date->formatted_from_date }} - {{ $date->formatted_to_date }}
                        </p>
                        <a class="card-header-icon">
                          <span class="icon">
                            <i class="fa fa-angle-down"></i>
                          </span>
                        </a>
                    </header>
                    <div class="card-content">
                        <div class="content">

                            <p>{{ __('From') }}: {{ $date->formatted_start_time }} -
                            {{ __('To') }}: {{ $date->formatted_end_time }}</p>
                            <em>{{ __('Price') }}: {{ $date->formatted_price }} p.p.</em>
                            <p>
                                <small>{{ __('Total options') }}: {{ $date->totalOptions() }}</small>
                            </p>

                        </div>
                    </div>
                    <footer class="card-footer">
                        <a class="card-footer-item" href="/dates/{{ $date->id }}/options">{{ __('Option a date') }}</a>
                        <a class="card-footer-item" href="/dates">{{ __('Back') }}</a>
                    </footer>
                </div>
            </div>
        </div>


    </div>

@endsection