@extends('layouts.master')

@section('title')
    All dates
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
                        <th>{{ __('Price') }}</th>
                        <th colspan="3"></th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($dates as $date)
                            <tr class=" {{ ($date->getStatusLabel() == 'Geboekt' ? 'is-grey' : '' )}}">
                            <td>{{ $date->getStatusLabel() }}</td>
                            <td>{{ $date->formatted_from_date }} {{ $date->formatted_start_time }}</td>
                            <td>{{ $date->formatted_to_date }} {{ $date->formatted_end_time }}</td>
                            <td>{{ $date->formatted_price }} p.p.</td>
                            <td>{{ $date->totalOptions() }} {{ __('optie genomen') }}</td>
                            <td><a href="dates/{{ $date->id }}" class="button is-grey">{{ __('More info') }}</a></td>
                            <td><a href="dates/{{ $date->id }}/options" {{ ($date->getStatusLabel() == 'Geboekt' ? 'disabled' : '' )}} class="button is-black">{{ __('Take option') }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

        </div>


    </div>

@endsection