@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (Session::has('flash_notification.general.message'))
                <div class="alert alert-{{ Session::get('flash_notification.general.level') }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    {{ Session::get('flash_notification.general.message') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ action('HomeController@index') }}">< Back</a> Points list <a href="{{ action('PointsController@add') }}" class="btn btn-success">Add new point</a></div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Paid</th>
                        </tr>
                    @foreach($points as $point)
                        <tr>
                            <td>{{ $point->id }}</td>
                            <td>{{ $point->getCoordinates->lat }}</td>
                            <td>{{ $point->getCoordinates->lon }}</td>
                            <td>{{ $point->paid ? 'Paid' : 'Free' }}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
