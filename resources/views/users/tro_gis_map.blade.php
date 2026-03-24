@extends('layouts.drafts.gis')

@section('title', 'TRO GIS Map')

@section('styles')
<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,container-queries"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

<!-- OpenLayers (UMD build so `ol` is available globally) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@latest/dist/ol.css" />
<script src="https://cdn.jsdelivr.net/npm/proj4@2.9.2/dist/proj4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ol@latest/dist/ol.js"></script>

<style>
    html, body { height: 100%; margin: 0; }
    #map {
        width: 100%;
        height: 100%;
        position: absolute;
        inset: 0;
    }
    .tool-btn.active { outline: 2px solid rgba(15, 23, 42, 0.3); }
    #popup { display: none; }
    
    /* Floating sidebar styles */
    #toolSidebar {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    #toolSidebar.translate-x-0 {
        transform: translateX(0);
    }
    
    #toolSidebar.translate-x-full {
        transform: translateX(100%);
    }
    
    #toolSidebar.opacity-100 {
        opacity: 1;
    }
    
    #toolSidebar.opacity-0 {
        opacity: 0;
    }
    
    #toolSidebar.visible {
        visibility: visible;
    }
    
    #toolSidebar.invisible {
        visibility: hidden;
    }
    
    /* Floating button animation */
    #floatingToolBtn {
        transition: all 0.2s ease-in-out;
    }
    
    #floatingToolBtn:hover {
        transform: scale(1.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>
@endsection

@section('content')
<div class="bg-slate-50">
    <div class="flex h-screen w-screen overflow-hidden">
        <!-- LEFT SIDEBAR -->
        <aside class="w-[340px] bg-white border-r border-slate-200 flex flex-col">
            <div class="px-4 py-3 border-b border-slate-200">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-[13px] font-bold text-slate-900">Traffic Regulation Orders (TRO) GIS</div>
                        <div class="text-[11px] text-slate-500 mt-1">EPSG:27700 British National Grid</div>
                    </div>
                    <button id="clearBtn" class="h-9 px-3 rounded-md border border-slate-200 bg-slate-50 hover:bg-slate-100 text-[12px]">
                        <i class="fa-solid fa-broom mr-1 text-[11px]"></i>Clear
                    </button>
                </div>
            </div>

            <!-- Annotation mode -->
            <div class="px-4 py-3 border-b border-slate-200 bg-slate-50/40">
                <div class="flex items-center justify-between gap-2">
                    <div class="text-[12px] font-bold text-slate-800">Annotation mode</div>
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input id="annotationToggle" type="checkbox" class="sr-only" checked />
                        <span class="w-11 h-6 bg-slate-200 rounded-full relative">
                            <span class="absolute top-[2px] left-[2px] w-5 h-5 bg-white rounded-full shadow transition-transform" id="toggleKnob"></span>
                        </span>
                        <span id="annotationToggleText" class="text-[11px] text-slate-600">ON</span>
                    </label>
                </div>
                <div class="mt-2 text-[11px] text-slate-500">Drawing/edit tools work only when ON.</div>
            </div>

            <!-- Tools Section (Hidden by default) -->
            <div id="toolsSection" class="px-4 py-3 border-b border-slate-200 hidden">
                <div class="text-[12px] font-bold text-slate-800 mb-2">Tools</div>
                
                <!-- Target Layer -->
                <div class="mb-3">
                    <div class="text-[11px] text-slate-600 mb-1">Target Layer</div>
                    <select id="targetLayer" class="w-full text-[11px] border border-slate-300 rounded-md px-2 py-1 bg-white">
                        <option value="static" selected>Static</option>
                        <option value="effective">Effective</option>
                        <option value="proposed">Proposed</option>
                        <option value="moving">Moving</option>
                        <option value="inventory">Inventory</option>
                    </select>
                </div>

                <!-- Drawing Tools -->
                <div class="mb-3">
                    <div class="text-[11px] text-slate-600 mb-2">Annotations</div>
                    <div class="grid grid-cols-2 gap-2">
                        <button class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200" data-draw="Point" title="Point">
                            <i class="fa-solid fa-circle text-slate-700 mr-2"></i>
                            <span>Point</span>
                        </button>
                        <button class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200" data-draw="LineString" title="Line">
                            <i class="fa-solid fa-minus text-slate-700 mr-2"></i>
                            <span>Line</span>
                        </button>
                        <button class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200" data-draw="Polygon" title="Polygon">
                            <i class="fa-solid fa-border-all text-slate-700 mr-2"></i>
                            <span>Polygon</span>
                        </button>
                        <button class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200" data-draw="Rectangle" title="Rectangle">
                            <i class="fa-solid fa-square text-slate-700 mr-2"></i>
                            <span>Rectangle</span>
                        </button>
                        <button class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200" data-draw="Circle" title="Circle">
                            <i class="fa-solid fa-circle text-slate-700 mr-2"></i>
                            <span>Circle</span>
                        </button>
                        <button class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200" data-draw="Arrow" title="Arrow">
                            <i class="fa-solid fa-arrow-right text-slate-700 mr-2"></i>
                            <span>Arrow</span>
                        </button>
                        <button class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200 col-span-2" data-draw="Text" title="Text">
                            <i class="fa-solid fa-font text-slate-700 mr-2"></i>
                            <span>Text</span>
                        </button>
                        <button id="editBtn" class="tool-btn h-10 rounded border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200" title="Select">
                            <i class="fa-solid fa-mouse-pointer text-slate-700 mr-2"></i>
                            <span>Select</span>
                        </button>
                    </div>
                </div>

                <!-- Measurement Tools -->
                <div class="mb-3">
                    <div class="text-[11px] text-slate-600 mb-2">Measurement</div>
                    <div class="space-y-2">
                        <button data-measure="distance" class="tool-btn w-full h-10 rounded border border-slate-200 bg-white hover:bg-green-50 hover:border-green-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200">
                            <i class="fa-solid fa-ruler text-slate-700 mr-2"></i>
                            <span>Distance</span>
                        </button>
                        <button data-measure="area" class="tool-btn w-full h-10 rounded border border-slate-200 bg-white hover:bg-green-50 hover:border-green-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200">
                            <i class="fa-solid fa-vector-square text-slate-700 mr-2"></i>
                            <span>Area</span>
                        </button>
                        <button id="clearMeasureBtn" class="w-full h-10 rounded border border-slate-200 bg-white hover:bg-red-50 hover:border-red-300 text-[10px] flex items-center justify-center px-2 transition-colors duration-200">
                            <i class="fa-solid fa-eraser text-slate-700 mr-2"></i>
                            <span>Clear</span>
                        </button>
                    </div>
                </div>

                <!-- Delete Button -->
                <button id="deleteFeatureBtn" class="w-full h-10 rounded border border-red-200 bg-red-50 hover:bg-red-100 hover:border-red-300 text-[10px] flex items-center justify-center transition-colors duration-200">
                    <i class="fa-solid fa-trash text-red-600 mr-2"></i>
                    <span>Delete</span>
                </button>
            </div>

            <!-- Orders -->
            <div class="px-4 py-3 flex-1 overflow-hidden">
                <div class="text-[12px] font-bold text-slate-800">Orders</div>
                <div class="mt-2">
                    <input id="orderSearch" type="text" placeholder="Search orders..." class="w-full text-[12px] border border-slate-300 rounded-md px-3 py-2 bg-white" />
                </div>
                <div class="mt-2 overflow-auto h-[350px] pr-1">
                    <div id="ordersList" class="space-y-2"></div>
                </div>

                <div class="mt-3">
                    <div class="text-[11px] text-slate-500 mb-1">Selected order</div>
                    <div id="effectiveFromText" class="text-[12px] font-semibold text-slate-900">—</div>
                    <div class="grid grid-cols-3 gap-2 mt-2">
                        <button id="orderDetailsBtn" class="h-9 tool-btn rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[11px]">Details</button>
                        <button id="orderConfirmBtn" class="h-9 tool-btn rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[11px]">Confirm</button>
                        <button id="orderScheduleBtn" class="h-9 tool-btn rounded-md border border-amber-200 bg-amber-50 hover:bg-amber-100 text-[11px]">Schedule</button>
                    </div>
                    <button id="orderDeleteBtn" class="w-full h-9 tool-btn rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[11px] mt-2">Delete</button>
                    <div class="mt-2 text-[11px] text-slate-500">Static TRO mode: UI-only actions.</div>
                </div>
            </div>
        </aside>

        <!-- MAP -->
        <section class="flex-1 relative">
            <!-- Floating Add Tool Button -->
            <button id="floatingToolBtn" class="fixed top-20 left-[348px] z-30 w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 group " title="Add tool">
                <i class="fa-solid fa-plus text-xl"></i>
                <!-- Tooltip -->
                <span class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none">
                    Add tool
                </span>
            </button>
            <!-- Toolbar: layer filters -->
            <div class="absolute top-3 left-20 right-3 z-20 flex items-center justify-between gap-3 pointer-events-none">
                <div class="flex items-center gap-2 pointer-events-auto">
                    <div class="bg-white/95 border border-slate-200 rounded-md px-2 py-2 flex items-center gap-2 flex-wrap">
                        <div class="text-[11px] font-bold text-slate-700 mr-1">Layers</div>
                        <button class="layer-btn tool-btn text-[11px] px-2 py-1 rounded bg-slate-900 text-white" data-filter="All">All</button>
                        <button class="layer-btn tool-btn text-[11px] px-2 py-1 rounded bg-emerald-600 text-white/95" data-filter="Effective">Effective</button>
                        <button class="layer-btn tool-btn text-[11px] px-2 py-1 rounded bg-amber-500 text-white/95" data-filter="Proposed">Proposed</button>
                        <button class="layer-btn tool-btn text-[11px] px-2 py-1 rounded bg-rose-500 text-white/95" data-filter="Static">Static</button>
                        <button class="layer-btn tool-btn text-[11px] px-2 py-1 rounded bg-lime-600 text-white/95" data-filter="Moving">Moving</button>
                        <button class="layer-btn tool-btn text-[11px] px-2 py-1 rounded bg-sky-600 text-white/95" data-filter="Inventory">Inventory</button>
                    </div>
                </div>

                <div class="flex items-center gap-2 pointer-events-auto">
                    <button id="exportBtn" class="h-10 px-3 rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[12px]">
                        <i class="fa-solid fa-file-export mr-1"></i>Export
                    </button>
                    <button id="importBtn" class="h-10 px-3 rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[12px]">
                        <i class="fa-solid fa-file-import mr-1"></i>Import
                    </button>
                    <button id="fullscreenBtn" class="h-10 px-3 rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[12px]">
                        <i class="fa-solid fa-up-right-and-down-left-from-center mr-1"></i>Full screen
                    </button>
                </div>
            </div>

            <div id="map"></div>

            <div class="absolute bottom-3 left-3 z-20 bg-white/95 border border-slate-200 rounded-md px-3 py-2 shadow-sm">
                <div class="text-[11px] text-slate-600">Coordinate (EPSG:27700)</div>
                <div id="coordText" class="text-[12px] font-semibold text-slate-900">X: —, Y: —</div>
                <div id="mouseFeatureText" class="text-[11px] text-slate-500 mt-1">Hover: —</div>
            </div>

            <div id="popup" class="absolute z-30 pointer-events-none">
                <div class="bg-slate-900 text-white rounded-md shadow-lg px-3 py-2 text-[12px] w-[270px]">
                    <div class="font-semibold" id="popupTitle">Feature</div>
                    <div class="text-white/80 mt-1" id="popupMeta">—</div>
                    <div class="text-white/60 mt-2 text-[11px]" id="popupCoord">—</div>
                </div>
            </div>
        </section>
    </div>

    <!-- EXPORT MODAL -->
    <div id="exportModal" class="fixed inset-0 bg-black/40 hidden z-[1000]">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] max-w-[95vw] bg-white rounded-lg shadow-xl border border-slate-200">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div class="font-bold text-slate-900 text-[13px]">Export GeoJSON (Drawings)</div>
                <button id="exportCloseBtn" class="h-9 px-3 rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[12px]">Close</button>
            </div>
            <div class="p-4">
                <textarea id="exportTextarea" class="w-full h-[420px] border border-slate-300 rounded-md p-3 text-[12px] font-mono" spellcheck="false"></textarea>
                <div class="mt-3 flex items-center gap-2">
                    <button id="copyExportBtn" class="h-10 px-3 rounded-md bg-slate-900 text-white text-[12px] hover:bg-slate-800">Copy</button>
                    <div class="text-[11px] text-slate-500">Exports only annotation features.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- IMPORT MODAL -->
    <div id="importModal" class="fixed inset-0 bg-black/40 hidden z-[1000]">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] max-w-[95vw] bg-white rounded-lg shadow-xl border border-slate-200">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div class="font-bold text-slate-900 text-[13px]">Import GeoJSON (Drawings)</div>
                <button id="importCloseBtn" class="h-9 px-3 rounded-md border border-slate-200 bg-white hover:bg-slate-50 text-[12px]">Close</button>
            </div>
            <div class="p-4">
                <textarea id="importTextarea" class="w-full h-[420px] border border-slate-300 rounded-md p-3 text-[12px] font-mono" spellcheck="false"></textarea>
                <div class="mt-3 flex items-center gap-2">
                    <button id="doImportBtn" class="h-10 px-3 rounded-md bg-emerald-600 text-white text-[12px] hover:bg-emerald-500">Import into target layer</button>
                    <div class="text-[11px] text-slate-500">Target layer is set in the sidebar.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Laravel CSRF Token
    const csrfToken = '{{ csrf_token() }}';
    
    // API Endpoints
    const API_ENDPOINTS = {
        orders: '{{ route("user.orders.api") }}',
        bookings: '{{ route("user.bookings.api") }}',
        saveAnnotation: '{{ route("user.annotations.store") }}',
        deleteAnnotation: '{{ route("user.annotations.delete") }}'
    };

    // Floating Tool Button functionality
    document.addEventListener('DOMContentLoaded', function() {
        const floatingToolBtn = document.getElementById('floatingToolBtn');
        const toolsSection = document.getElementById('toolsSection');
        const ordersSection = document.querySelector('.px-4.py-3.flex-1.overflow-hidden');
        
        console.log('DOM loaded, elements found:', {
            floatingToolBtn: !!floatingToolBtn,
            toolsSection: !!toolsSection,
            ordersSection: !!ordersSection
        });
        
        // Toggle tools when clicking floating button
        floatingToolBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Floating button clicked!');
            
            if (toolsSection.classList.contains('hidden')) {
                // Show tools, hide orders
                toolsSection.classList.remove('hidden');
                ordersSection.style.display = 'none';
                
                // Change plus to X icon
                this.querySelector('i').classList.remove('fa-plus');
                this.querySelector('i').classList.add('fa-times');
                
                console.log('Tools shown, orders hidden');
            } else {
                // Hide tools, show orders
                toolsSection.classList.add('hidden');
                ordersSection.style.display = 'block';
                
                // Change X back to plus icon
                this.querySelector('i').classList.remove('fa-times');
                this.querySelector('i').classList.add('fa-plus');
                
                console.log('Tools hidden, orders shown');
            }
        });
        
        // Unit conversion buttons
        document.querySelectorAll('[data-unit]').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active state from all unit buttons
                document.querySelectorAll('[data-unit]').forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-white');
                });
                
                // Add active state to clicked button
                this.classList.remove('bg-white');
                this.classList.add('bg-blue-600', 'text-white');
                
                console.log('Unit changed to:', this.getAttribute('data-unit'));
            });
        });
        
        // Clear measurements button
        document.getElementById('clearMeasureBtn').addEventListener('click', function() {
            if (typeof measureLayer !== 'undefined') {
                measureLayer.getSource().clear();
                console.log('Measurements cleared');
            }
        });
    });
</script>

<script src="{{ asset('js/tro-gis-map.js') }}"></script>
@endsection
