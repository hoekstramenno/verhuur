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
                    </header>
                    {!! Form::open(['url' => 'dates/' . $date->id . '/options']) !!}
                    <div class="card-content">
                        <div class="content">


                            <?php $pax = 5; $email = ''; ?>
                            @if(null !== old('pax'))
                                <?php $pax = old('pax'); ?>
                            @endif

                            @if(null !== old('email'))
                                <?php $email = old('email'); ?>
                            @endif

                                <?php $emailerror = ''; ?>
                            @if ($errors->has('email'))
                               <?php $emailerror = 'is-danger' ?>
                            @endif


                            {!! Form::token() !!}


                            {!! Form::label('email', 'E-Mail Address', ['class' => 'field']) !!}
                                <p class="control has-icons-left has-icons-right">
                                {!! Form::text('email', $email, ['class' => 'input ' . $emailerror]) !!}
                                <span class="icon is-small is-left">
                                  <i class="fa fa-envelope"></i>
                                </span>
                                    @if ($errors->has('email'))
                                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                                    @endif
                            </p>
                            {!! Form::label('pax', 'Total Persons') !!}
                            {!! Form::number('pax', $pax, ['min' => 5]) !!}



                        </div>
                    </div>
                    <footer class="card-footer">
                        {!! Form::submit('Click Me!', ['class' => 'card-footer-item']) !!}
                        <a class="card-footer-item" href="/dates">Terug</a>
                    </footer>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>


    </div>

@endsection