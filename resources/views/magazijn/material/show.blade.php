@extends('layouts.master')

@section('content')
    <section class="hero is-medium is-primary is-bold">
        <div class="container">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        {{ $material->name }}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-three-quarters">

                    <div class="content">


                        <table>
                            <tbody>
                            <tr>
                                <td>Hoeveelheid</td>
                                <td>{{ $material->qty }}</td>
                            </tr>
                            <tr>
                                <td>Size</td>
                                <td>{{ $material->size }}</td>
                            </tr>
                            <tr>
                                <td>Opgeslagen</td>
                                <td>{{ $material->storage }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>




                    @foreach ($remarks as $remark)
                        @include ('magazijn.material.remark')
                    @endforeach

                    {{ $remarks->links() }}

                    @if (auth()->check())

                        <div class="remark-form">
                            <form method="POST" action="{{ $material->path() . '/remarks' }}">
                                {{ csrf_field() }}


                                <div class="field">
                                    <div class="control">
                                        <textarea class="body" name="body" placeholder="Wat is er mis"></textarea>
                                    </div>
                                </div>


                                <button type="submit" class="button is-primary">Add remark</button>
                            </form>
                        </div>

                    @else
                    <section class="section">
                        <div class="content">
                            <p class="has-text-centered">Please
                                <a href="{{ route('login') }}">sign in</a>
                                to add remarks to this material.
                            </p>
                        </div>
                    </section>
                    @endif
                </div>


                <div class="column">
                    <div class="content">
                        <p>
                            This material was published {{ $material->created_at->diffForHumans() }} and currently
                            has {{ $material->remarks_count }} {{ str_plural('remark', $material->remarks_count) }}.
                        </p>
                    </div>

                    {{--@can ('update', $material)--}}
                    <form action="{{ $material->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="button is-danger">Delete</button>
                    </form>
                    {{--@endcan--}}

                </div>
            </div>
        </div>
    </section>

@endsection