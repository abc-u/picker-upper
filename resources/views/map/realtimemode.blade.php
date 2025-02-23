@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/map.css') }}" />

    @if (Route::currentRouteName() === 'map.realtimemode')
        @foreach ($tags as $tag)
            <a href="{{ route('map.filterByTagRealTimeMode', $tag->id) }}" class="btn btn-outline-primary m-1 tag-btn">
                {{ $tag->body }}
            </a>
        @endforeach
    @else
        @foreach ($tags as $tag)
            <a href="{{ route('map.realtimemode') }}" class="btn btn-secondary">全て表示</a>
            <p class="btn m-1 tag-btn btn-primary">
                {{ $tag->body }}
            </p>
        @endforeach
    @endif

    <h2 class="title-span">Google Maps API - Laravel</h2>
    <div id="map" style="width: 100%; height: 500px;"></div>

    <!-- LaravelのデータをJavaScriptに渡す -->
    <script>
        var locations = @json($locations);
    </script>

    <script>
        var map;
        var currentInfoWindow = null; // 現在開いている情報ウィンドウを管理

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: {
                    lat: 10.332853,
                    lng: 123.907750
                },
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            // 現在地を取得し、地図の中心に設定
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation); // 地図の中心を現在地に
                    new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: "現在地"
                    });
                }, function() {
                    console.warn("現在地を取得できませんでした。デフォルト位置を使用します。");
                });
            } else {
                console.warn("このブラウザでは現在地取得がサポートされていません。");
            }

            locations.forEach(function(location) {
                if (location.latitude && location.longitude) {
                    var marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(location.latitude),
                            lng: parseFloat(location.longitude)
                        },
                        map: map
                    });

                    var infoWindow = new google.maps.InfoWindow({
                        content: `
                        <div style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                            <h5 style="font-size: 14px; margin-bottom: 5px;">${location.title}</h5>
                            <a href="${location.url}" style="word-break: break-word;">詳細を見る</a>
                        </div>
                    `
                    });

                    marker.addListener("click", function() {
                        if (currentInfoWindow) {
                            currentInfoWindow.close();
                        }
                        infoWindow.open(map, marker);
                        currentInfoWindow = infoWindow;
                    });
                }
            });
        }
    </script>
@endsection
