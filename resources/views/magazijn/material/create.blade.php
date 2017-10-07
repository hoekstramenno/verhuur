@extends('layouts.master')

@section('title')
    {{ __('All Material') }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ __('All Material') }}</div>

                    <div class="panel-body">
                        <form action="/magazijn/materiaal" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="brand_id">Choose a Brand:</label>
                                <select required name="brand_id" id="brand_id" class="form-control">
                                    <option value="">Choose one...</option>
                                    @foreach($brands as $brand)
                                        <option {{ old('brand_id') == $brand->id ? 'selected' : '' }} value="{{$brand->id}}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type_id">Choose a Type:</label>
                                <select name="type_id" id="type_id" class="form-control">
                                    <option value="">Choose one...</option>
                                    @foreach($types as $type)
                                        <option {{ old('type_id') == $type->id ? 'selected' : '' }} value="{{$type->id}}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Name:</label>
                                <input required type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"/>
                            </div>
                            <div class="form-group">
                                <label for="body">Quantity:</label>
                                <input required type="number" name="qty" id="qty" class="form-control" value="{{ old('qty') }}"/>
                            </div>
                            <div class="form-group">
                                <label for="body">Size:</label>
                                <input required type="text" name="size" id="size" class="form-control" value="{{ old('size') }}"/>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Add material</button>
                            </div>
                            @if (count($errors))
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
