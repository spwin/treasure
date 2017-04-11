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

                    <div id="map" style="height: 400px;"></div>

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
@push('scripts')
<script>
    var map;

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 53.768643, lng: -2.692716 }
        });

        @foreach($points as $point)
                addPoint({{ $point->getCoordinates->lat }}, {{ $point->getCoordinates->lon }}, {{ $point->paid }});
        @endforeach

        function addPoint(lat, lng, paid){
            var latLng = new google.maps.LatLng(lat, lng);
            placeMarker(latLng, paid);
        }

        function placeMarker(location, paid) {
            paid = typeof paid !== 'undefined' ? paid : false;

            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            if(paid){
                marker.setLabel("$");
            }
        }
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap">
</script>
@endpush
