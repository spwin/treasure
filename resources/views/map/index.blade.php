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
                        <h1>Points list</h1>
                        <a href="{{ action('PointsController@add') }}" class="btn btn-success">Add new points</a>
                        <a href="{{ action('PointsController@delete') }}" class="btn btn-danger pull-right">Delete all</a>
                    </div>

                    <div class="panel-body">
                        <p>Total towers: <strong>{{ count($towers) }}</strong></p>
                        <ul>
                        @foreach($robot1_queue as $element)
                            <li>ID: {{ $element->id }} | LAT: {{ $element->lat }} | LON: {{ $element->lon }} | Date: {{ $element->created_at }}</li>
                        @endforeach
                        </ul>
                        <div id="map" style="height: 400px;"></div>
                        {!! Form::open([
                            'method' => 'POST',
                            'action' => ['MapController@update'],
                            'id' => 'update-config'
                        ]) !!}
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Default</th>
                            </tr>
                            @foreach($configuration as $config)
                                <tr>
                                    <td>{{ $config->id }}</td>
                                    <td>{{ $config->key }}</td>
                                    <td>{!! Form::text($config->key.'[value]', $config->value) !!}</td>
                                    <td>
                                        {!! Form::hidden($config->key.'[default]', $config->default) !!}
                                        {{ $config->default }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <button type="submit" class="btn btn-primary btn-xl">Save configuration</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var map;
    var markers = [];
    var users = [];

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: {lat: 51.477478, lng: 0.009591 }
        });

        @foreach($points as $point)
                addPoint({{ $point->lat }}, {{ $point->lon }}, '{{ $point->type }}');
        @endforeach

        function addPoint(lat, lng, type){
            var latLng = new google.maps.LatLng(lat, lng);
            placeMarker(latLng, type);
        }

        function placeMarker(location, type) {
            type = typeof type !== 'undefined' ? type : 'resource';

            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            marker.setLabel(type.charAt(0).toUpperCase());

            if(type.equals('user')){
                users.push(marker);
            } else {
                markers.push(marker);
            }

        }

        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

    }
</script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap">
</script>
@endpush
