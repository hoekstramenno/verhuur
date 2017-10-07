@extends('layouts.admin')


@section('content')
    <h1>Dates</h1>
    <div class="">
        <div class="content">
            <table class="table is-striped is-fullwidth">
                <thead>
                <tr>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Days</th>
                    <th>Total Options</th>
                    <th>Status</th>
                    <th>CP</th>
                    <th>Type of group</th>
                    <th>Option date</th>
                    <th>Booked date</th>
                    <th>Paid</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>

                @forelse ($dates as $date)
                    <tr>
                        <td>
                            <a href="/admin{{ $date->path() }}">
                                {{ date('d/m/Y', strtotime($date->date_from)) }}
                            </a>
                        </td>
                        <td>
                            {{ date('d/m/Y', strtotime($date->date_to)) }}
                        </td>
                        <td>
                            {{ $date->date_from->diffInDays($date->date_to) }}
                        </td>
                        <td>
                            <?php echo $date->options->count() ?>
                        </td>
                        <td>
                            {{ $date->getStatusLabel() }}
                        </td>
                        <td>
                            @if ($date->bookings->count() > 0)
                                {{ $date->bookings->first()->option->email  }}
                            @endif
                        </td>
                        <td>
                            Scouting
                        </td>
                        <td>
                            @if ($date->bookings->count() > 0)
                                {{ date('d/m/Y', strtotime($date->bookings->first()->option->created_at)) }}
                            @endif
                        </td>
                        <td>
                            @if ($date->bookings->count() > 0)
                                {{ date('d/m/Y', strtotime($date->bookings->first()->created_at)) }}
                            @endif
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            Contract
                        </td>
                        <td>
                            Factuur
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td>There are no relevant results this time</td>
                    </tr>
                @endforelse
            </table>
            {{ $dates->links('_partials.pagination') }}
        </div>
    </div>
@endsection