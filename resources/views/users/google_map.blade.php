@extends('layouts.drafts.app')

@section('title', 'Map')

@section('styles')@endsection

@section('content')

<div class="flex flex-wrap gap-3 p-6">
  <iframe id="mapFrame" src="https://www.google.com/maps/d/embed?mid=1KE3Tlm1Bhe4ZbE5bzhD69BZb7Js&hl=en_US&ehbc=2E312F" 
                    style="border:0;" 
                    allowfullscreen>
            </iframe>
            
            <div class="w-72 p-6 bg-gray-100">
              <h1 class="text-xl font-medium mb-4">A map showing the 33 London boroughs (including the City of London Corporation). Each borough is managed by a local council</h1>
              <p class="text-sm font-normal mb-1 text-gray-600">2,289,601 views</p>
              <p class="text-sm font-normal mb-5 text-gray-600">Published on April 9, 2016</p>
              <p class="text-1xl font-bold mb-3 text-slate-800">London Boroughs</p>
              <div id="boroughsList" class="w-full bg-gray-100"></div>
              </div>

</div>

<script>
    function resizeIframe() {
        const iframe = document.getElementById('mapFrame');
        iframe.style.width = `${window.innerWidth*0.7}px`;
        iframe.style.height = `${window.innerHeight}px`;
    }

    function populateBoroughsList() {
        const boroughs = [
            "Borough 1",
            "Borough 2",
            "Borough 3",
            "Borough 4",
            "Borough 5"
        ];

        const boroughsList = document.getElementById('boroughsList');
        boroughsList.innerHTML = boroughs.map(borough => `<p class="cursor-pointer hover:bg-gray-200 p-2">${borough}</p>`).join('');
    }

    // Resize iframe on load and when window is resized
    window.addEventListener('load', () => {
        resizeIframe();
        populateBoroughsList();
    });
    window.addEventListener('resize', resizeIframe);
</script>


@endsection

