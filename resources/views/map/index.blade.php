@extends('layouts.layout')

@section('content')

@if (Route::currentRouteName() === 'map.index')
@foreach ($tags as $tag)
<a href="{{ route('map.filterByTag', $tag->id) }}" class="btn btn-outline-primary m-1 tag-btn">
    {{ $tag->body }}
</a>
@endforeach
@else
@foreach ($tags as $tag)
<a href="{{ route('map.index') }}" class="btn btn-secondary">全て表示</a>
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
                        // すでに開いている情報ウィンドウがあれば閉じる
                        if (currentInfoWindow) {
                            currentInfoWindow.close();
                        }

                        // 新しい情報ウィンドウを開く
                        infoWindow.open(map, marker);

                        // 現在の情報ウィンドウを更新
                        currentInfoWindow = infoWindow;
                    });
                }
            });

            // 現在地に移動するボタンのクリックイベント
            document.getElementById("current-location-btn").addEventListener("click", function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        // マップの中心を現在地に更新
                        map.setCenter(userLocation);

                    }, function() {
                        alert("現在地を取得できませんでした。");
                    });
                } else {
                    alert("このブラウザでは現在地取得がサポートされていません。");
                }
            });
        }
    </script>

    <button id="current-location-btn" type="button">現在地に移動</button>
@endsection
