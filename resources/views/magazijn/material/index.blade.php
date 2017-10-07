@extends('layouts.master')

@section('content')
    <section class="hero is-medium is-primary is-bold">
        <div class="container">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        All materials
                    </h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="content">
            <table class="table is-striped is-fullwidth">
                <thead>
                <tr>
                    <th><abbr title="Index">index</abbr></th>
                    <th>Material</th>
                    <th>Aantal</th>
                    <th><abbr title="Total Remarks">Total Remarks</abbr></th>
                    <th></th>
                </tr>
                </thead>
                @forelse ($materials as $material)

                    <tr>
                        <td>

                                {{ $material->id }}

                        </td>
                        <td>

                                {{ $material->name }} {{ $material->size }}

                        </td>
                        <td>

                            {{ $material->qty }}

                        </td>
                        <td>
                            <a href="{{ $material->path() }}">
                                {{ $material->remarks_count }} {{ str_plural('remark', $material->remarks_count) }}
                            </a>
                        </td>
                        <td>
                        @if ($material->disapproved == 1)
                                <span class="icon has-text-danger">
              <i class="fa fa-lg fa-ban"></i>
            </span>
                        @endif
                        </td>
                    </tr>

            @empty
                <p>There are no relevant results this time</p>
            @endforelse
        </table>
            {{ $materials->links('_partials.pagination') }}
    </div>
    </div>
@endsection
