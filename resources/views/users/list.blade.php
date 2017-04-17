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
                <div class="panel-heading">
                    <a href="{{ action('HomeController@index') }}">< Back</a>
                    <h1>Users list</h1>
                </div>

                <div class="panel-body">

                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Crystals</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Last activity</th>
                        </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->crystals}}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->ip }}</td>
                            <td>{{ $user->getCoordinates ? $user->getCoordinates->lat : '-'}}</td>
                            <td>{{ $user->getCoordinates ? $user->getCoordinates->lon : '-'}}</td>
                            <td>{{ $user->getCoordinates ? date($user->getCoordinates->updated_at) : '-'}}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection