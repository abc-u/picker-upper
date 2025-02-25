@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/map.css') }}" />

    @if (Route::currentRouteName() === 'map.realtimemode')
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
        var markers = []; // 追加: マーカーの配列

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
                        if (currentInfoWindow) {
                            currentInfoWindow.close();
                        }
                        infoWindow.open(map, marker);
                        currentInfoWindow = infoWindow;
                    });

                    markers.push({
                        marker,
                        infoWindow,
                        location
                    }); // マーカーと情報を保存
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

                        // 最も近いマーカーを取得
                        var nearest = findNearestMarker(userLocation);
                        if (nearest) {
                            if (currentInfoWindow) {
                                currentInfoWindow.close();
                            }
                            nearest.infoWindow.open(map, nearest.marker);
                            currentInfoWindow = nearest.infoWindow;
                        }

                    }, function() {
                        alert("現在地を取得できませんでした。");
                    });
                } else {
                    alert("このブラウザでは現在地取得がサポートされていません。");
                }
            });
        }

        function findNearestMarker(userLocation) {
            let nearest = null;
            let minDistance = Infinity;
            let nearestLocation = null; // 追加: 最も近いロケーション情報を保存

            markers.forEach(({
                marker,
                infoWindow,
                location
            }) => {
                var distance = getDistance(userLocation.lat, userLocation.lng, marker.getPosition().lat(), marker
                    .getPosition().lng());
                if (distance < minDistance) {
                    minDistance = distance;
                    nearest = {
                        marker,
                        infoWindow
                    };
                    nearestLocation = location; // 追加: 最も近いロケーションのデータを保存
                }
            });

            // 最も近いマーカーの情報を表示
            {{--  if (nearestLocation !== null) {
                let infoHtml = `<h4>最も近い場所の情報</h4>`;
                infoHtml += `<p><strong>ID:</strong> ${nearestLocation.id}</p>`;
                infoHtml += `<p><strong>タイトル:</strong> ${nearestLocation.title}</p>`;
                infoHtml +=
                    `<p><strong>URL:</strong> <a href="${nearestLocation.url}" target="_blank">${nearestLocation.url}</a></p>`;
                infoHtml += `<p><strong>緯度:</strong> ${nearestLocation.latitude}</p>`;
                infoHtml += `<p><strong>経度:</strong> ${nearestLocation.longitude}</p>`;

                document.getElementById("nearest-location-info").innerHTML = infoHtml;
            }  --}}

            return nearest;
        }




        // 2点間の距離を計算する関数 (Haversine Formula)
        function getDistance(lat1, lng1, lat2, lng2) {
            const R = 6371; // 地球の半径 (km)
            const dLat = (lat2 - lat1) * (Math.PI / 180);
            const dLng = (lng2 - lng1) * (Math.PI / 180);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }
    </script>

    <div id="nearest-location-info" style="margin-top: 10px; font-weight: bold;"></div>


    <button id="current-location-btn" type="button">現在地に移動</button>

@endsection
