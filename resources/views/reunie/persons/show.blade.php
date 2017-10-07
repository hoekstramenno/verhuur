@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                {{ $material->name }}
                            </span>

                            {{--@can ('update', $material)--}}
                                <form action="{{ $material->path() }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-link">Delete Material</button>
                                </form>
                            {{--@endcan--}}
                        </div>
                    </div>

                    <div class="panel-body">
                        Qty: {{ $material->qty }} <br/>
                        Opmerkingen: {{ $material->size }} <br/>
                    </div>
                </div>

                @foreach ($remarks as $remark)
                    @include ('magazijn.material.remark')
                @endforeach

                {{ $remarks->links() }}

                {{--@if (auth()->check())--}}
                    <form method="POST" action="{{ $material->path() . '/remarks' }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Wat is er mis"
                                    rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                {{--@else--}}
                    {{--<p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this--}}
                        {{--discussion.</p>--}}
                {{--@endif--}}
            </div>

            {{--<div class="col-md-4">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-body">--}}
                        {{--<p>--}}
                            {{--This thread was published {{ $material->created_at->diffForHumans() }} by--}}
                            {{--<a href="#">{{ $material->creator->name }}</a>, and currently--}}
                            {{--has {{ $material->replies_count }} {{ str_plural('comment', $material->replies_count) }}.--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection