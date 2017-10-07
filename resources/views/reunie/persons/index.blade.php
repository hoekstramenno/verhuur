@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @forelse($materials as $material)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $material->path() }}">
                                        {{ $material->name }}
                                    </a>
                                </h4>
                                <a href="{{ $material->path() }}">
                                    {{ $material->remarks_count }} {{ str_plural('remark', $material->remarks_count) }}
                                </a>
                            </div>
                        </div>

                        <div class="panel-body">

                            <article>
                                <div class="body">{{ $material->size }}</div>
                            </article>
                        </div>
                    </div>
                @empty
                    <p>There are no relevant results this time</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
