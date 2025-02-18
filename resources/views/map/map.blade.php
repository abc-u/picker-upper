@extends('layouts.layout')

@section('content')

<h1>Google Maps API - Laravel</h1>
<div id="map" style="width: 100%; height: 500px;"></div>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: { lat: 10.332853, lng: 123.907750 }, // デフォルト座標
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
    }
</script>

@endsection
