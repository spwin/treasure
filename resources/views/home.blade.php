@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a href="{{ action('MapController@index') }}">Map Resources View</a>
                    {{--<a href="{{ action('PointsController@index') }}">Points list</a>
                    <a href="{{ action('UsersController@index') }}">Users list</a>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
