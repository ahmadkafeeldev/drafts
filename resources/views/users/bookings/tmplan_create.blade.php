<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leaflet Map with Draw Tools</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (with Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    html, body { height: 100%; margin: 0; }
    #map { height: 100%; }
    #info {
      position: absolute;
      bottom: 10px;
      left: 10px;
      background: white;
      padding: 6px 10px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
      font-family: Arial, sans-serif;
      font-size: 13px;
      z-index: 1000;
    }
    .color-panel {
      position: absolute;
      top: 8px;
      left: 200px;
      background: white;
      padding: 5px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
      z-index: 1200;
      font-family: Arial, sans-serif;
      font-size: 13px;
    }
    .tool-block { margin-bottom: 10px; }
    .tool-block span { display: inline-block; width: 70px; font-weight: bold; }
    .color-btn {
      display: inline-block;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      margin: 2px;
      cursor: pointer;
      border: 1px solid #ccc;
    }
    #sidebar.hidden { display: none; }
    .line-style-btn {
      margin-left: 5px;
      padding: 2px 6px;
      font-size: 12px;
      cursor: pointer;
    }
    .leaflet-control-geocoder {
      position: absolute !important;
      right: 70% !important;
      top: 10px !important;
      transform: translateX(-100%) !important;
      z-index: 2000;
    }
    .leaflet-control-geocoder-expanded { width: 250px !important; }
    .leaflet-control-geocoder input {
      display: block !important;
      width: 100% !important;
      padding: 4px 8px;
      font-size: 13px;
    }
     .map-icons {
      position: absolute;
      top: 300px;   /* below zoom control */
      left: 10px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      z-index: 1500;
    }

    /* Each icon button */
    .map-icon-btn {
      width: 45px;
      height: 45px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
      cursor: pointer;
      transition: transform 0.s2 ease;
    }

    .map-icon-btn img {
      width: 60%;
      height: 60%;
      object-fit: contain;
      pointer-events: none;
    }

    /* Shrink on hover, then pop back */
    .map-icon-btn:hover {
      transform: scale(1.9);
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <div id="info">Move cursor to see distance from center</div>
  <div class="map-icons">
    <div class="map-icon-btn" id="btn1">
      <img src="{{ asset('uploads/Screenshot 2025-09-12 033821.png') }}" alt="Icon 1">
    </div>
    <div class="map-icon-btn" id="btn2">
      <img src="{{ asset('uploads/Screenshot 2025-09-12 033849.png') }}" alt="Icon 2">
    </div>
    <div class="map-icon-btn" id="btn3">
      <img src="{{ asset('uploads/Screenshot 2025-09-12 033923.png') }}" alt="Icon 3">
    </div>
   <a href="https://www.firstpros.net/smartapp/public/admin"> <div class="map-icon-btn" id="btn4">
      <img src="{{ asset('uploads/Screenshot 2025-09-12 033946.png') }}" alt="Icon 4">
    </div></a>
  </div>
  <!-- Color & style panel -->
  <div class="color-panel" id="colorPanel">
    <div class="tool-block" data-tool="polyline">
     
      <button class="line-style-btn" data-type="solid">SYL</button>
      <button class="line-style-btn" data-type="dotted">DYL</button>
      <button class="line-style-btn" data-type="double">BAYS</button>
      <br/>
       <span>Line</span>
      <div class="color-btn" style="background:green" data-color="green"></div>
      <div class="color-btn" style="background:yellow" data-color="yellow"></div>
       <div class="color-btn" style="background:blue" data-color="blue"></div>
    </div>
  </div>

  <!-- Sidebar toggle -->
  <!--<button id="toggleSidebar" -->
  <!--  style="position:absolute; right:130px; top:20px; z-index:1600; background:white; padding:6px 10px; border:1px solid #ccc; cursor:pointer;">-->
  <!--  📂 Show Maps-->
  <!--</button>-->

  <!--<div id="sidebar" class="hidden" style="position:absolute;right:0;top:70px;width:250px;height:100%;background:#f8f8f8;overflow:auto;padding:10px;z-index:1500;border-left:1px solid #ccc;">-->
  <!--  <h4>Saved Maps</h4>-->
  <!--  <ul id="savedMaps"></ul>-->
  <!--</div>-->


 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.geometryutil/0.9.3/leaflet.geometryutil.min.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
  const map = L.map('map').setView([51.505, -0.09], 13);

  const baseLayers = {
    "OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }),
  };
  baseLayers["OpenStreetMap"].addTo(map);
//   L.control.layers(baseLayers).addTo(map);

  const info = document.getElementById("info");
  const center = map.getCenter();
  map.on("mousemove", function(e) {
    const latlng = e.latlng;
    const dist = map.distance(center, latlng); 
    const distText = dist > 1000 ? (dist/1000).toFixed(2) + " km" : dist.toFixed(0) + " m";
    info.innerHTML = `Cursor: ${latlng.lat.toFixed(5)}, ${latlng.lng.toFixed(5)}<br>
                      Distance from center: ${distText}`;
  });

  const drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  // Default tool colors and line style
  const toolColors = { polyline:"yellow", polygon:"green", rectangle:"orange" };
  let lineStyle = "solid";

  // Handle color selection
  document.querySelectorAll(".color-btn").forEach(btn => {
    btn.addEventListener("click", function() {
      const tool = btn.closest(".tool-block").dataset.tool;
      toolColors[tool] = this.dataset.color;
      alert(tool + " color set to " + this.dataset.color);
    });
  });

  // Handle line style selection
  document.querySelectorAll(".line-style-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      lineStyle = btn.dataset.type;
      alert("Polyline style set to " + lineStyle);
    });
  });

  const drawControl = new L.Control.Draw({
    edit: { featureGroup: drawnItems },
    draw: {
      polygon: false,
      polyline: { shapeOptions: { color: toolColors.polyline } },
      rectangle: false,
      circle: false,
      marker: false,
      circlemarker: false
    }
  });
  map.addControl(drawControl);

  map.on(L.Draw.Event.CREATED, function (e) {
    const type = e.layerType;
    let layer = e.layer;

    // Apply styles + store properties for saving
    if (layer.setStyle && type !== "polyline") {
      layer.setStyle({
        color: toolColors[type],
        fillColor: toolColors[type]
      });
    }

    if (type === "polyline") {
      if (lineStyle === "dotted") {
        layer.setStyle({ color: toolColors.polyline, dashArray: "6, 6" });
      } else if (lineStyle === "double") {
        // main thick line
        layer.setStyle({ color: toolColors.polyline, weight: 12 });
        // shadow line
        const shadow = L.polyline(layer.getLatLngs(), {
          color: "white",
          weight: 6
        }).addTo(drawnItems);
        drawnItems.addLayer(L.layerGroup([layer, shadow]));
        return;
      } else {
        layer.setStyle({ color: toolColors.polyline });
      }
    }

    // Add metadata into feature properties
    layer.feature = layer.feature || { type: "Feature", properties: {} };
    layer.feature.properties.color = toolColors[type] || "blue";
    if (type === "polyline") {
      layer.feature.properties.lineStyle = lineStyle;
    }

    drawnItems.addLayer(layer);
  });

  // Save button
  const saveBtn = L.control({position: 'topleft'});
  saveBtn.onAdd = function () {
    const btn = L.DomUtil.create('button');
    btn.innerHTML = "Save Map";
    btn.style.background = "white";
    btn.style.padding = "5px";
    btn.style.cursor = "pointer";
    
    L.DomEvent.on(btn, 'click', function () {
      const geojson = drawnItems.toGeoJSON();

      // Ask user for map name
      const mapName = prompt("Enter map name:", "My Map");
      if (!mapName) {
        alert("Map name is required!");
        return;
      }

      fetch("{{ route('user.tmplan_store') }}", {
        method: "POST",
        headers: { 
          "Content-Type": "application/json", 
          "X-CSRF-TOKEN": "{{ csrf_token() }}" 
        },
        body: JSON.stringify({ 
          user_id: 1, 
          name: mapName,
          geojson 
        })
      })
      .then(r => r.json())
      .then(data => { 
        alert(data.message || "Map saved!"); 
        loadMaps(); 
      })
      .catch(err => console.error("Save error:", err));
    });
    
    return btn;
  };
  map.addControl(saveBtn);

  // Sidebar map loader
  const sidebar = document.getElementById("sidebar");
  function loadMaps() {
    fetch("{{ route('user.tmplan_list') }}")
      .then(r => r.json())
      .then(data => {
        if (!data.success) return;
        sidebar.innerHTML = "<h4>Saved Maps</h4>";
        data.plans.forEach(plan => {
          const btn = document.createElement("button");
          btn.innerHTML = plan.name;
          btn.style.display = "block";
          btn.style.margin = "5px 0";
          btn.style.padding = "5px";
          btn.style.width = "100%";
          btn.style.cursor = "pointer";

          btn.onclick = () => {
            drawnItems.clearLayers();
            let geo = plan.geojson;
            if (typeof geo === "string") { 
              try { geo = JSON.parse(geo); } catch (e) { return; } 
            }

            const layer = L.geoJSON(geo, {
              style: f => ({
                color: (f.properties && f.properties.color) || "blue",
                fillColor: (f.properties && f.properties.color) || "blue",
                dashArray: (f.properties && f.properties.lineStyle === "dotted") ? "6,6" : null,
                weight: (f.properties && f.properties.lineStyle === "double") ? 12 : 4
              })
            });

            layer.eachLayer(l => drawnItems.addLayer(l));

            // zoom to saved map
            setTimeout(() => {
              try {
                map.fitBounds(layer.getBounds().pad(0.2));
              } catch (e) {
                if (geo.type === "Point" || 
                   (geo.features && geo.features.length === 1 && geo.features[0].geometry.type === "Point")) {
                  map.setView(layer.getLayers()[0].getLatLng(), 16);
                }
              }
            }, 100);
          };
          sidebar.appendChild(btn);
        });
      })
      .catch(err => console.error("Load error:", err));
  }

  // Geocoder
  const geocoder = L.Control.geocoder({
    defaultMarkGeocode: false
  }).on('markgeocode', function(e) {
    const bbox = e.geocode.bbox;
    const poly = L.polygon([
      bbox.getSouthEast(),
      bbox.getNorthEast(),
      bbox.getNorthWest(),
      bbox.getSouthWest()
    ]);
    map.fitBounds(poly.getBounds());
    L.marker(e.geocode.center).addTo(map)
      .bindPopup(e.geocode.name).openPopup();
    map.addLayer(drawnItems);
  }).addTo(map);

  // Sidebar toggle
  const sidebarEl = document.getElementById("sidebar");
  const toggleBtn = document.getElementById("toggleSidebar");
  toggleBtn.addEventListener("click", () => {
    if (sidebarEl.classList.contains("hidden")) {
      sidebarEl.classList.remove("hidden");
      toggleBtn.innerHTML = "📂 Hide Maps";
    } else {
      sidebarEl.classList.add("hidden");
      toggleBtn.innerHTML = "📂 Show Maps";
    }
  });

  loadMaps();
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to show modal with dynamic content
    function showModal(title, content) {
        document.getElementById("mapModalLabel").innerText = title;
        document.getElementById("mapModalBody").innerHTML = content;
        var modal = new bootstrap.Modal(document.getElementById("mapModal"));
        modal.show();
    }

    // Button click events
    document.getElementById("btn1").addEventListener("click", function() {
        showModal("First Icon", "<p>This is popup for Icon 1</p>");
    });

    document.getElementById("btn2").addEventListener("click", function() {
        showModal("Second Icon", "<p>This is popup for Icon 2</p>");
    });

    document.getElementById("btn3").addEventListener("click", function() {
        showModal("Third Icon", "<p>This is popup for Icon 3</p>");
    });

    // btn4 can stay without popup
});
</script>
<!-- Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapModalLabel">Popup Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="mapModalBody">
        Popup content goes here...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>












{{--@extends('layouts.drafts.app')

@section('title', 'TM Plan System')

@section('styles')
@endsection

@section('content')

<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbGJ0nHKwThHErjZiDltG7uU26s35fd34&libraries=places&callback=initMap"></script>-->
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet Draw CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Leaflet Draw JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>


<!-- Use the latest version of html2canvas and jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


<style>
    
    #map, #googleMap {
        height: 67vh;
    }

    canvas {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
    }
    
    #map-container {
      position: relative;
      width: 800px;
      height: 600px;
      border: 1px solid #000;
      background-color: #f3f3f3;
    }

    .toolbar {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    button {
      padding: 10px;
      cursor: pointer;
      margin-right: 5px;
    }

    #yellow-btn {
      background-color: yellow;
    }

    #red-btn {
      background-color: red;
    }

    .label-box, .closure-label {
      position: absolute;
      padding: 5px;
      background-color: #fff;
      border: 1px solid #000;
      cursor: pointer;
    }

    .route-label {
      background-color: lightblue;
    }

    .closure-label {
      background-color: lightcoral;
    }

    .closed-dot {
      width: 10px;
      height: 10px;
      background-color: red;
      border-radius: 50%;
      position: absolute;
    }
    
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Initialize map at London
    var map = L.map('map').setView([51.5074, -0.1278], 12);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Layer for drawn items
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Add drawing controls
    var drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems
        },
        draw: {
            polygon: {
                shapeOptions: {
                    color: '#ff0000',   // Red outline
                    fillColor: '#ff6666', // Light red fill
                    fillOpacity: 0.6
                }
            },
            polyline: {
                shapeOptions: {
                    color: '#0000ff',  // Blue line
                    weight: 4
                }
            },
            rectangle: {
                shapeOptions: {
                    color: '#28a745',   // Green rectangle
                    fillColor: '#71d988',
                    fillOpacity: 0.5
                }
            },
            circle: {
                shapeOptions: {
                    color: '#ff9900',   // Orange border
                    fillColor: '#ffcc66',
                    fillOpacity: 0.4
                }
            },
            marker: {
                icon: L.icon({
                    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34]
                })
            }
        }
    });
    map.addControl(drawControl);

    // Event when user finishes drawing
    map.on(L.Draw.Event.CREATED, function (event) {
        var layer = event.layer;

        // Apply custom random color to each polygon dynamically
        if (event.layerType === 'polygon') {
            layer.setStyle({
                color: getRandomColor(),
                fillColor: getRandomColor(),
                fillOpacity: 0.6
            });
        }

        drawnItems.addLayer(layer);

        // Export drawn shape as GeoJSON
        var geojson = layer.toGeoJSON();
        console.log("Drawn Shape:", geojson);

        // Save to backend
        fetch('/save-map-shape', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ shape: geojson })
        }).then(res => res.json())
          .then(data => console.log("Saved:", data));
    });

    // Utility function for random colors
    function getRandomColor() {
        return "#" + Math.floor(Math.random() * 16777215).toString(16);
    }
});

</script>

<div class="row">
        <div class="col-md-12 ">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
    </div>

<div>
    <p class="mb-6 text-2xl text-slate-800 font-bold mt-6">
        Draw your map using left down key of mouse to add source and destination.
    </p>
    
    <div class="relative">
      <input id="location-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
             type="text" placeholder="Search for a location" >
    </div>

   <div class="flex justify-center items-center gap-3">
    <label for="color-select">Select Color: </label>
    <select id="color-select">
        <option value="red">Red</option>
        <option value="yellow">Yellow</option>
    </select>

    <button id="road-closed-btn" type="button" class="bg-red-500 text-white px-4 py-2 rounded font-medium text-xl cursor-pointer">Road Ahead Closed</button>

    <button id="diversion-btn" type="button" class="bg-yellow-500 text-white px-4 py-2 rounded font-medium text-xl cursor-pointer">
        Diversion
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18"/>
        </svg>
    </button>

    <button id="diversion-end-btn" type="button" class="bg-yellow-500 text-white px-4 py-2 rounded font-medium text-xl cursor-pointer">Diversion Ends</button>

    <button id="box-label-btn" type="button" class="bg-gray-500 text-white px-4 py-2 rounded font-medium text-xl cursor-pointer">Box With Label</button>

    <button id="closure-label-btn" type="button" class="bg-gray-700 text-white px-4 py-2 rounded font-medium text-xl cursor-pointer">Closure Label Container</button>
</div>


    <form action="{{ route('user.tmplan_store') }}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
        <div id="contentToCapture" class="p-3">
            <div class="w-full h-1/2 border border-gray-100 rounded-lg my-3" tyle="position: relative; height: 500px; width: 100%;">
                <div id="map" class="w-full map-container h-full rounded-lg"></div>
            </div>
            
            <a href="#" onclick="map1.clearMap()" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Clear Draw Map</a>
            <a href="#" onclick="generatePDF()" class="text-gray-900 bg-white bg-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Generate PDF</a>
        
            
            <h2 class="mt-6 mb-4 text-2xl text-slate-800 font-bold">Selected Locations:</h2>
            <ul class="space-y-1 text-xl text-slate-800 list-none list-inside mb-2 flex flex-col items-start justify-center w-full">
                <li class="flex justify-center items-center gap-4 max-w-md"><span class="max-w-md font-bold">Source Location:</span> <input name="source" id="source" class="max-w-md bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed " required /></li>
                <li class="flex justify-center items-center gap-4 max-w-md"><span class="max-w-md font-bold">Destination Location:</span> <input name="destination" id="destination" class="max-w-md bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed " required /></li>
                <li class="flex justify-center items-center gap-4 max-w-md"><span class="max-w-md font-bold">Total Distance (KM):</span> <input name="distance" id="distance" class="max-w-md bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed " required /></li>
            </ul>
        </div>

        <button type="submit"
                class="text-gray-900 bg-white bg-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
            Save & Download PDF
        </button>

    </form>
</div>

@endsection

@section('scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbGJ0nHKwThHErjZiDltG7uU26s35fd34&libraries=places&callback=initMap"></script>
@endsection --}}
