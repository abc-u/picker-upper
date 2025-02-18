@extends('layouts.layout')

@section('content')
    <h1>Google Maps API - Laravel</h1>
    <div id="map" style="width: 100%; height: 500px;"></div>

    <!-- LaravelのデータをJavaScriptに渡す -->
    <script>
        var locations = @json($locations);
    </script>

    <script>
        var map;

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
                            <div>
                                <h5>${location.title}</h5>
                                <a href="${location.url}" class="">詳細を見る</a>
                            </div>
                        `
                    });

                    marker.addListener("click", function() {
                        infoWindow.open(map, marker);
                    });

                    infoWindow.open(map, marker);
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

                        // 現在地のマーカーを追加
                        new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: "現在地"
                        });

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
