@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ action('PointsController@index') }}">< Back</a> Add Point</div>

                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Form::model($point,[
                        'method' => 'POST',
                        'action' => ['PointsController@save'],
                        'class' => 'inline'
                        ]) !!}
                    <div class="col-md-4">
                            {!! Form::label('lat', 'Latitude') !!}
                            {!! Form::input('number', 'lat', null, ['class' => 'form-control', 'placeholder' => 'Latitude', 'step' => '0.000001']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('lon', 'Longitude') !!}
                        {!! Form::input('number', 'lon', null, ['class' => 'form-control', 'placeholder' => 'Longitude', 'step' => '0.000001']) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::checkbox('paid', 1, null) !!}
                        {!! Form::label('paid', 'Paid') !!}
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-xl pull-right phrase-add">Add phrase</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
