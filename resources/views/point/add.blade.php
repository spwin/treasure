@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ action('PointsController@index') }}">< Back</a> Add Point
                    {!! Form::model($point,[
                            'method' => 'POST',
                            'action' => ['PointsController@save'],
                            'class' => 'pull-right',
                            'id' => 'save-points'
                            ]) !!}
                    <button type="submit" class="btn btn-primary btn-xl">Save points</button>
                    {!! Form::close() !!}
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">

                    <div id="map" style="height: 400px;"></div>

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

                    <div id="markers-list">
                        <table class="table">
                            <tr>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Paid</th>
                                <th>Action</th>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <td>{!! Form::input('number', 'new_lat', null, ['class' => 'form-control', 'placeholder' => 'Latitude', 'step' => '0.000001']) !!}</td>
                                <td>{!! Form::input('number', 'new_lng', null, ['class' => 'form-control', 'placeholder' => 'Longitude', 'step' => '0.000001']) !!}</td>
                                <td>{!! Form::checkbox('new_paid', 1, null) !!}</td>
                                <td><button type="submit" class="btn btn-success btn-xl marker-add">Add Point</button></td>
                            </tr>
                        </table>
                        <table class="table" id="markers-table">
                            <tbody></tbody>
                        </table>
                    </div>

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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    var markersTable = $('#markers-table tbody');
    var elements = [];
    var map;
    var markerAdd = $('.marker-add');

    $('#save-points').on("submit", function(e){
        var form = $(this);
        markersTable.find('tr').each(function(){
            var checked = $(this).find('.marker-paid').is(':checked') ? '1' : '0';
            form.append('<input type="hidden" name="lat[]" value="'+$(this).find('.marker-lat').html()+'">')
                    .append('<input type="hidden" name="lng[]" value="'+$(this).find('.marker-lng').html()+'">')
                    .append('<input type="hidden" name="paid[]" value="'+checked+'">');
        });
    });

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 53.768643, lng: -2.692716 }
        });

        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);
        });

        markerAdd.on("click", function(e){
            e.preventDefault();
            addPoint();
        });

        function addPoint(){
            var lat = $('input[name="new_lat"]');
            var lng = $('input[name="new_lng"]');
            var latLng = new google.maps.LatLng(lat.val(), lng.val());
            var paid = $('input[name="new_paid"]');

            placeMarker(latLng, paid.is(':checked'));
            lat.val(''); lng.val(''); paid.prop('checked', false);
        }

        function markGray(elementHtml){
            markersTable.find('tr').removeClass('background-gray');
            elementHtml.addClass('background-gray');
        }

        function placeMarker(location, paid) {
            paid = typeof paid !== 'undefined' ? paid : false;

            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            var elementHtml = $('<tr>')
                    .append(($('<td>').addClass('marker-lat')).append(parseFloat(location.lat()).toFixed(6)))
                    .append(($('<td>').addClass('marker-lng')).append(parseFloat(location.lng()).toFixed(6)))
                    .append(($('<td>').addClass('marker-paid')).append('<input type="checkbox" class="marker-paid">'))
                    .append($('<td>').append(($('<button>').addClass("btn btn-danger")).append("Remove")));

            if(paid){
                marker.setLabel("$");
                elementHtml.find('input').prop('checked', true);
            }

            markersTable.prepend(elementHtml);
            markGray(elementHtml);

            var id = elements.push({
                'html': elementHtml,
                'marker': marker
            });

            elementHtml.addClass('marker-'+id);

            elementHtml.find('button').on("click", function(){
                marker.setMap(null);
                elementHtml.remove();
            });

            elementHtml.find('input').on("change", function(){
                if($(this).is(':checked')){
                    marker.setLabel("$");
                } else {
                    marker.setLabel("");
                }
            });

            elementHtml.on("click", function(){
                map.setCenter(marker.getPosition());
                markGray(elementHtml);
            });

            elementHtml.find('input, button').on("click", function(e){
                e.stopPropagation();
            });

            marker.addListener("click", function(){
                markGray(elementHtml);
                //marker.setMap(null);
            });

            marker.addListener("dblclick", function(){
                elementHtml.remove();
                marker.setMap(null);
            });
        }
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap">
</script>
@endpush
