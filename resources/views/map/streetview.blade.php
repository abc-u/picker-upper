@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/map.css') }}" />

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

    <!-- ストリートビューのコンテナ -->
    <div id="street-view" style="width: 100%; height: 500px; margin-top: 20px; display: none; position: relative;"></div>

    <script>
        var locations = @json($locations);
        var userIcon = "{{ asset('assets/img/' . auth()->user()->user_icon) }}"; // ユーザーアイコンのパス

        var map;
        var panorama;
        var currentInfoWindow = null;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: { lat: 10.332853, lng: 123.907750 },
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            panorama = new google.maps.StreetViewPanorama(document.getElementById("street-view"), {
                pov: { heading: 0, pitch: 0 },
                visible: false
            });

            map.setStreetView(panorama);

            locations.forEach(function(location) {
                if (location.latitude && location.longitude) {
                    var marker = new google.maps.Marker({
                        position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
                        map: map
                    });

                    var infoWindow = new google.maps.InfoWindow({
                        content: `
                        <div style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                            <h5 style="font-size: 14px; margin-bottom: 5px;">${location.title}</h5>
                            <a href="javascript:void(0);" onclick="showStreetView(${location.latitude}, ${location.longitude})">ストリートビューを見る</a>
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

            document.getElementById("current-location-btn").addEventListener("click", function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var userLocation = { lat: position.coords.latitude, lng: position.coords.longitude };
                        map.setCenter(userLocation);
                    }, function() {
                        alert("現在地を取得できませんでした。");
                    });
                } else {
                    alert("このブラウザでは現在地取得がサポートされていません。");
                }
            });
        }

        function showStreetView(lat, lng) {
            panorama.setPosition({ lat: lat, lng: lng });
            panorama.setVisible(true);
            document.getElementById("street-view").style.display = "block";

            addOverlayToStreetView(panorama);
        }

        function addOverlayToStreetView(panorama) {
            class CustomOverlay extends google.maps.OverlayView {
                constructor(panorama) {
                    super();
                    this.panorama = panorama;
                    this.div = null;
                }

                onAdd() {
                    this.div = document.createElement("div");
                    this.div.style.position = "absolute";
                    this.div.style.width = "1000px";
                    this.div.style.height = "1000px";
                    this.div.style.background = "url('" + userIcon + "') no-repeat center";
                    this.div.style.backgroundSize = "contain";
                    this.div.style.opacity = "0.9";
                    this.div.style.borderRadius = "50%";

                    const panes = this.getPanes();
                    panes.overlayLayer.appendChild(this.div);
                }

                draw() {
                    if (!this.div) return;

                    const projection = this.getProjection();
                    const latLng = this.panorama.getPosition();
                    const point = projection.fromLatLngToDivPixel(latLng);

                    if (point) {
                        this.div.style.left = `${point.x - 50}px`;
                        this.div.style.top = `${point.y - 50}px`;
                    }
                }

                onRemove() {
                    if (this.div) {
                        this.div.parentNode.removeChild(this.div);
                        this.div = null;
                    }
                }
            }

            const overlay = new CustomOverlay(panorama);
            overlay.setMap(panorama.getMap());
        }
    </script>

    <button id="current-location-btn" type="button">現在地に移動</button>

@endsection
