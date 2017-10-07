@extends('layouts.admin')


@section('content')
    <h1>Dates</h1>
    <div class="">
        @include('_partials.errors')
        <div class="content">
            <form method="post" action="{{ route('admin.dates.update', ['date' => $date]) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="field">
                    <label class="label">Date From</label>
                    <div class="control">
                        <input class="input" type="text" value="{{ date('d-m-Y', strtotime($date->date_from)) }}" name="date_from" placeholder="Date From">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Date To</label>
                    <div class="control">
                        <input class="input" type="text" value="{{ date('d-m-Y', strtotime($date->date_to)) }}" name="date_to" placeholder="Date To">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Status</label>
                    <div class="control">
                        <div class="select">
                            <select name="status">
                                @foreach ($date->listStatus() as $key => $status)
                                    <option {{ ($date->status == $key ? 'selected' : '') }} value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox" value="1" name="published" {{ ($date->published_at ? 'checked' : '') }}>
                            Published
                        </label>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <input type="submit" value="Submit" class="button is-primary" />
                    </div>
                    <div class="control">

                            <a href="{{ route('admin.dates.index') }}" class="button is-link">Cancel</a>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection