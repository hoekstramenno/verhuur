@extends('layouts.master')

@section('title')
    {{ __('All dates') }}
@endsection


@section('content')
    <div class="container">
        <div class="content">

            <table>
                <thead>
                <tr>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('From') }}</th>
                    <th>{{ __('To') }}</th>
                    <th colspan="3"></th>
                </tr>
                </thead>

                <tbody>

                <list-of-available-dates></list-of-available-dates>
                </tbody>
            </table>

        </div>


    </div>


@endsection