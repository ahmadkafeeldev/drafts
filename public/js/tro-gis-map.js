// -----------------------------
// EPSG:27700 (British National Grid)
// -----------------------------
const EPSG_27700 = 'EPSG:27700';
const epsg27700Def = "+proj=tmerc +lat_0=49 +lon_0=-2 +k=0.9996012717 +x_0=400000 +y_0=-100000 +ellps=airy +towgs84=446.448,-125.157,542.06,0.15,0.247,0.842,-20.489 +units=m +no_defs";
proj4.defs(EPSG_27700, epsg27700Def);
const olGlobal = window.ol;
if (!olGlobal) {
    console.error('OpenLayers failed to load: window.ol is undefined');
    const mapEl = document.getElementById('map');
    if (mapEl) mapEl.textContent = 'OpenLayers failed to load (window.ol is undefined).';
    throw new Error('OpenLayers failed to load');
}
// Register EPSG:27700 definition for proj4-backed transforms
olGlobal.proj.proj4.register(proj4);
const proj27700 = olGlobal.proj.get(EPSG_27700);
const viewCenterRaw = olGlobal.proj.transform([-0.1060, 51.5140], 'EPSG:4326', EPSG_27700).slice();
const viewCenter = (Array.isArray(viewCenterRaw) && viewCenterRaw.length === 2 && isFinite(viewCenterRaw[0]) && isFinite(viewCenterRaw[1]))
    ? viewCenterRaw
    : [531000, 182000]; // Specific London area coordinates

function to27700([lon, lat]) {
    return olGlobal.proj.transform([lon, lat], 'EPSG:4326', EPSG_27700);
}

// -----------------------------
// Styles
// -----------------------------
function styleForOrderFeature(feature) {
    const type = feature.get('type');
    const status = feature.get('status');
    let strokeColor = '#ef4444';
    let lineDash = [10, 8];
    if (type === 'loading_restriction' || type === 'waiting_loading_restriction') {
        strokeColor = '#f59e0b';
        lineDash = [3, 6];
    }
    return new ol.style.Style({
        stroke: new ol.style.Stroke({ color: strokeColor, width: 4, lineDash, lineCap: 'round', lineJoin: 'round' }),
        fill: new ol.style.Fill({ color: status === 'proposed' ? 'rgba(245, 158, 11, 0.12)' : 'rgba(239, 68, 68, 0.10)' })
    });
}

function styleForAnnotationFeature(feature) {
    const geomType = feature.getGeometry().getType();
    const labelText = feature.get('labelText') || '';

    if (geomType === 'Point') {
        const styles = [
            new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 6,
                    fill: new ol.style.Fill({ color: '#6366f1' }),
                    stroke: new ol.style.Stroke({ color: '#ffffff', width: 2 })
                })
            })
        ];
        if (labelText) {
            styles.push(new ol.style.Style({
                text: new ol.style.Text({
                    font: 'bold 14px Calibri, Arial, sans-serif',
                    fill: new ol.style.Fill({ color: '#111827' }),
                    stroke: new ol.style.Stroke({ color: '#ffffff', width: 3 }),
                    offsetY: -14,
                    text: labelText
                })
            }));
        }
        return styles;
    }

    return new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: '#6366f1',
            width: 3,
            lineDash: feature.get('shapeType') === 'Arrow' ? [8, 6] : undefined,
            lineCap: 'round',
            lineJoin: 'round'
        }),
        fill: (geomType === 'Polygon' || geomType === 'MultiPolygon') ? new ol.style.Fill({ color: 'rgba(99,102,241,0.12)' }) : undefined
    });
}

function layerStyle(feature) {
    if (feature.get('isOrder') === true) return styleForOrderFeature(feature);
    return styleForAnnotationFeature(feature);
}

// -----------------------------
// Dynamic Orders from Laravel API
// -----------------------------
let DYNAMIC_ORDERS = [];

// Fetch orders from Laravel API
async function fetchOrders() {
    try {
        const response = await fetch(API_ENDPOINTS.orders, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const orders = await response.json();
            DYNAMIC_ORDERS = orders.map(order => ({
                id: order.id || `T${order.id}`,
                title: order.title || `Order ${order.id}`,
                type: order.order_type || 'no_waiting',
                status: order.status || 'static',
                effectiveFrom: order.effective_from || new Date().toISOString().split('T')[0],
                geometry: order.geometry || {
                    type: 'LineString',
                    coordinates: order.coordinates || [[-0.1420, 51.4010], [-0.1370, 51.4040]]
                }
            }));
            renderOrders(DYNAMIC_ORDERS);
            loadOrderFeatures();
        } else {
            console.warn('Failed to fetch orders, using static data');
            loadStaticOrders();
        }
    } catch (error) {
        console.warn('API fetch failed, using static data:', error);
        loadStaticOrders();
    }
}

// Fallback to static orders
function loadStaticOrders() {
    DYNAMIC_ORDERS = [
        { id: 'T550', title: 'Demo Order', type: 'waiting_loading_restriction', status: 'static', effectiveFrom: '2009-12-23',
          geometry: { type: 'LineString', coordinates: [[-0.1420, 51.4010], [-0.1370, 51.4040], [-0.1310, 51.4070]] } },
        { id: 'T718', title: 'Ref 004 (Proposed)', type: 'no_waiting', status: 'proposed', effectiveFrom: '2025-01-05',
          geometry: { type: 'LineString', coordinates: [[-0.1180, 51.4045], [-0.1135, 51.4072], [-0.1090, 51.4095]] } },
        { id: 'T716', title: 'Ref 004 (Moving)', type: 'loading_restriction', status: 'moving', effectiveFrom: '2025-01-05',
          geometry: { type: 'Polygon', coordinates: [[[-0.1220, 51.4060], [-0.1188, 51.4080], [-0.1160, 51.4062], [-0.1192, 51.4042], [-0.1220, 51.4060]]] } },
        { id: 'T772', title: 'Ref 004 (Inventory)', type: 'no_waiting', status: 'inventory', effectiveFrom: '2025-01-05',
          geometry: { type: 'LineString', coordinates: [[-0.0980, 51.4090], [-0.0930, 51.4108], [-0.0880, 51.4130]] } },
        { id: 'T705', title: 'Ref 004 (Effective)', type: 'loading_restriction', status: 'effective', effectiveFrom: '2025-01-05',
          geometry: { type: 'LineString', coordinates: [[-0.1060, 51.4025], [-0.1000, 51.4048], [-0.0950, 51.4072]] } }
    ];
    renderOrders(DYNAMIC_ORDERS);
    loadOrderFeatures();
}

// -----------------------------
// Map + layers
// -----------------------------
// Base map tiles: keep tile grid in EPSG:3857 but reproject to current view projection.
const osm3857 = new ol.source.XYZ({
    url: 'https://{a-c}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    projection: 'EPSG:3857',
    wrapX: true
});

const map = new ol.Map({
    target: 'map',
    layers: [new ol.layer.Tile({ source: osm3857 })],
    view: new ol.View({ projection: proj27700, center: viewCenter, zoom: 15, maxZoom: 20, minZoom: 10 }),
    // Some OpenLayers bundles may not expose ol.control.defaults().
    // Add controls manually for maximum compatibility.
    controls: []
});

// Ensure correct size after layout/DOM
map.updateSize();
window.addEventListener('resize', () => map.updateSize());
setTimeout(() => map.updateSize(), 50);

// Manual controls (avoid ol.control.defaults)
map.addControl(new ol.control.Zoom());
map.addControl(new ol.control.ScaleLine({ units: 'metric' }));
if (ol.control.Attribution) {
    map.addControl(new ol.control.Attribution({ collapsible: true }));
}

const orderLayers = {
    static: new ol.layer.Vector({ source: new ol.source.Vector(), visible: true, style: layerStyle }),
    effective: new ol.layer.Vector({ source: new ol.source.Vector(), visible: false, style: layerStyle }),
    proposed: new ol.layer.Vector({ source: new ol.source.Vector(), visible: false, style: layerStyle }),
    moving: new ol.layer.Vector({ source: new ol.source.Vector(), visible: false, style: layerStyle }),
    inventory: new ol.layer.Vector({ source: new ol.source.Vector(), visible: false, style: layerStyle }),
};
Object.values(orderLayers).forEach((l) => map.addLayer(l));

const measureLayer = new ol.layer.Vector({
    source: new ol.source.Vector(),
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({ color: '#0ea5e9', width: 2, lineDash: [4, 3] }),
        fill: new ol.style.Fill({ color: 'rgba(14,165,233,0.12)' })
    })
});
map.addLayer(measureLayer);

const orderHighlightLayer = new ol.layer.Vector({
    source: new ol.source.Vector(),
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({ color: '#06b6d4', width: 7, lineDash: [2, 4], lineCap: 'round' }),
        fill: new ol.style.Fill({ color: 'rgba(6,182,212,0.15)' })
    })
});
map.addLayer(orderHighlightLayer);

function featureFromOrder(order) {
    const geom = order.geometry;
    let olGeom = null;
    if (geom.type === 'LineString') olGeom = new ol.geom.LineString(geom.coordinates.map(to27700));
    if (geom.type === 'Polygon') {
        const rings = geom.coordinates.map((ring) => ring.map(to27700));
        olGeom = new ol.geom.Polygon(rings);
    }
    if (!olGeom) return null;
    const f = new ol.Feature(olGeom);
    f.set('isOrder', true);
    f.set('id', order.id);
    f.set('title', order.title);
    f.set('type', order.type);
    f.set('status', order.status);
    f.set('effectiveFrom', order.effectiveFrom);
    return f;
}

const orderFeatureById = new Map();

function loadOrderFeatures() {
    // Clear existing features
    Object.values(orderLayers).forEach(layer => {
        layer.getSource().clear();
    });
    orderFeatureById.clear();

    // Add new features
    DYNAMIC_ORDERS.forEach((o) => {
        const f = featureFromOrder(o);
        if (!f) return;
        orderLayers[o.status].getSource().addFeature(f);
        orderFeatureById.set(o.id, f);
    });
}

// -----------------------------
// Orders UI
// -----------------------------
const ordersListEl = document.getElementById('ordersList');
const orderSearchEl = document.getElementById('orderSearch');
const effectiveFromText = document.getElementById('effectiveFromText');
const orderBtnById = new Map();

function renderOrders(list) {
    ordersListEl.innerHTML = '';
    orderBtnById.clear();
    list.forEach((o) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'w-full text-left px-3 py-2 rounded-md border border-slate-200 hover:bg-slate-50 bg-white';
        btn.innerHTML = `
            <div class="font-semibold text-[12px] text-slate-900">${o.id}</div>
            <div class="text-[11px] text-slate-600 mt-1">${o.title}</div>
            <div class="text-[10px] text-slate-500 mt-1">${o.type.replaceAll('_', ' ')}</div>
        `;
        btn.addEventListener('click', () => selectOrder(o.id));
        ordersListEl.appendChild(btn);
        orderBtnById.set(o.id, btn);
    });
}

function getFilteredOrders() {
    const q = (orderSearchEl.value || '').trim().toLowerCase();
    if (!q) return DYNAMIC_ORDERS;
    return DYNAMIC_ORDERS.filter((o) => `${o.id} ${o.title} ${o.type} ${o.status}`.toLowerCase().includes(q));
}

orderSearchEl.addEventListener('input', () => {
    renderOrders(getFilteredOrders());
    if (selectedOrderId) {
        const b = orderBtnById.get(selectedOrderId);
        if (b) b.click();
    }
});

let selectedOrderId = null;

function selectOrder(orderId) {
    selectedOrderId = orderId;
    const order = DYNAMIC_ORDERS.find((x) => x.id === orderId);
    if (!order) return;
    effectiveFromText.textContent = `${order.effectiveFrom} • ${order.status}`;
    for (const [id, btn] of orderBtnById.entries()) {
        btn.classList.toggle('border-slate-900', id === orderId);
        btn.classList.toggle('bg-slate-50', id === orderId);
    }
    const f = orderFeatureById.get(orderId);
    if (!f) return;
    map.getView().fit(f.getGeometry().getExtent(), { padding: [20, 20, 20, 20], maxZoom: 18 });
    orderHighlightLayer.getSource().clear();
    orderHighlightLayer.getSource().addFeature(f.clone());
}

// Order action buttons
document.getElementById('orderDetailsBtn').addEventListener('click', () => {
    const o = DYNAMIC_ORDERS.find((x) => x.id === selectedOrderId);
    if (!o) return;
    alert(`Details\n\nID: ${o.id}\nTitle: ${o.title}\nType: ${o.type}\nStatus: ${o.status}\nEffective from: ${o.effectiveFrom}`);
});

document.getElementById('orderConfirmBtn').addEventListener('click', () => {
    const o = DYNAMIC_ORDERS.find((x) => x.id === selectedOrderId);
    if (!o) return;
    if (confirm(`Confirm order ${o.id}?`)) {
        // Here you would make an API call to confirm the order
        alert(`Order ${o.id} confirmed (demo mode)`);
    }
});

document.getElementById('orderScheduleBtn').addEventListener('click', () => {
    const o = DYNAMIC_ORDERS.find((x) => x.id === selectedOrderId);
    if (!o) return;
    const newDate = prompt(`Schedule order ${o.id}. Enter new effective date (YYYY-MM-DD):`, o.effectiveFrom);
    if (newDate) {
        // Here you would make an API call to schedule the order
        alert(`Order ${o.id} scheduled for ${newDate} (demo mode)`);
    }
});

document.getElementById('orderDeleteBtn').addEventListener('click', () => {
    const o = DYNAMIC_ORDERS.find((x) => x.id === selectedOrderId);
    if (!o) return;
    if (confirm(`Delete order ${o.id}? This action cannot be undone.`)) {
        // Here you would make an API call to delete the order
        alert(`Order ${o.id} deleted (demo mode)`);
    }
});

// -----------------------------
// Layer filters
// -----------------------------
const filterButtons = Array.from(document.querySelectorAll('.layer-btn'));
function applyFilter(filter) {
    const show = {
        static: filter === 'All' || filter === 'Static',
        effective: filter === 'All' || filter === 'Effective',
        proposed: filter === 'All' || filter === 'Proposed',
        moving: filter === 'All' || filter === 'Moving',
        inventory: filter === 'All' || filter === 'Inventory',
    };
    Object.keys(orderLayers).forEach((k) => orderLayers[k].setVisible(show[k]));
    orderHighlightLayer.getSource().clear();
    if (selectedOrderId) selectOrder(selectedOrderId);
}
filterButtons.forEach((b) => b.addEventListener('click', () => applyFilter(b.getAttribute('data-filter'))));
applyFilter('All');

// -----------------------------
// Popup + hover
// -----------------------------
const popup = document.getElementById('popup');
const popupTitle = document.getElementById('popupTitle');
const popupMeta = document.getElementById('popupMeta');
const popupCoord = document.getElementById('popupCoord');
const coordText = document.getElementById('coordText');
const mouseFeatureText = document.getElementById('mouseFeatureText');

function showPopup(clientX, clientY, title, meta, coordStr) {
    popup.style.display = 'block';
    popup.style.left = `${clientX + 12}px`;
    popup.style.top = `${clientY + 12}px`;
    popupTitle.textContent = title;
    popupMeta.textContent = meta;
    popupCoord.textContent = coordStr;
}
function hidePopup() { popup.style.display = 'none'; }

map.on('pointermove', (evt) => {
    const c = evt.coordinate;
    coordText.textContent = `X: ${c[0].toFixed(0)}, Y: ${c[1].toFixed(0)}`;
    const f = map.forEachFeatureAtPixel(evt.pixel, (x) => x, { hitTolerance: 4 });
    if (!f) { mouseFeatureText.textContent = 'Hover: —'; hidePopup(); return; }

    if (f.get('isOrder') === true) {
        mouseFeatureText.textContent = `Hover: ${f.get('id')} • ${f.get('status')}`;
        showPopup(evt.clientX, evt.clientY, `Order ${f.get('id')}`, f.get('title'), `X: ${c[0].toFixed(0)}, Y: ${c[1].toFixed(0)}`);
    } else if (f.get('annotation') === true) {
        mouseFeatureText.textContent = `Hover: Annotation • ${f.get('shapeType') || 'feature'}`;
        showPopup(evt.clientX, evt.clientY, 'Annotation', f.get('labelText') ? `Label: ${f.get('labelText')}` : `Layer: ${f.get('annotationLayer') || '-'}`, `X: ${c[0].toFixed(0)}, Y: ${c[1].toFixed(0)}`);
    } else {
        mouseFeatureText.textContent = 'Hover: —';
        hidePopup();
    }
});

map.on('click', (evt) => {
    const f = map.forEachFeatureAtPixel(evt.pixel, (x) => x, { hitTolerance: 4 });
    if (!f) return;
    if (f.get('isOrder') === true) selectOrder(f.get('id'));
});

// -----------------------------
// Annotation tools (draw/edit/delete)
// -----------------------------
const annotationToggle = document.getElementById('annotationToggle');
const toggleKnob = document.getElementById('toggleKnob');
const toggleText = document.getElementById('annotationToggleText');
toggleKnob.style.transform = 'translateX(20px)';
let annotationActive = true;

function setAnnotationMode(on) {
    annotationActive = on;
    annotationToggle.checked = on;
    toggleKnob.style.transform = on ? 'translateX(20px)' : 'translateX(0px)';
    toggleText.textContent = on ? 'ON' : 'OFF';
    stopActiveTool();
}
annotationToggle.addEventListener('change', (e) => setAnnotationMode(!!e.target.checked));

function getTargetLayerKey() { return document.getElementById('targetLayer').value; }
function getTargetSource() { return orderLayers[getTargetLayerKey()].getSource(); }

let activeDraw = null;
let activeMeasure = null;
let activeModify = null;
let arrowHandlers = [];
let measureTooltipEl = null;

const annotationsSelect = new ol.interaction.Select({
    layers: Object.values(orderLayers),
    filter: (f) => f.get('annotation') === true,
    hitTolerance: 6,
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({ color: '#111827', width: 4, lineDash: [2, 6] }),
        fill: new ol.style.Fill({ color: 'rgba(17,24,39,0.12)' }),
        image: new ol.style.Circle({ radius: 7, fill: new ol.style.Fill({ color: '#111827' }), stroke: new ol.style.Stroke({ color: '#fff', width: 2 }) })
    })
});
map.addInteraction(annotationsSelect);

let selectedAnnotationFeature = null;
annotationsSelect.on('select', (e) => { selectedAnnotationFeature = e.selected[0] || null; });

function stopActiveTool() {
    if (activeDraw) { map.removeInteraction(activeDraw); activeDraw = null; }
    if (activeMeasure) { map.removeInteraction(activeMeasure); activeMeasure = null; }
    if (activeModify) { map.removeInteraction(activeModify); activeModify = null; }
    if (arrowHandlers.length) {
        arrowHandlers.forEach(({ handler }) => map.un('singleclick', handler));
        arrowHandlers = [];
    }
    if (measureTooltipEl) { measureTooltipEl.remove(); measureTooltipEl = null; }
}

// Delete selected annotation (+ remove paired arrow head if present)
document.getElementById('deleteFeatureBtn').addEventListener('click', () => {
    if (!annotationActive) return;
    if (!selectedAnnotationFeature) return;
    const groupId = selectedAnnotationFeature.get('annotationGroupId');
    Object.values(orderLayers).forEach((layer) => {
        const src = layer.getSource();
        const toRemove = src.getFeatures().filter((f) => f === selectedAnnotationFeature || (groupId && f.get('annotationGroupId') === groupId));
        toRemove.forEach((f) => src.removeFeature(f));
    });
    selectedAnnotationFeature = null;
    annotationsSelect.getFeatures().clear();
});

// Edit selected annotation
document.getElementById('editBtn').addEventListener('click', () => {
    if (!annotationActive) return;
    stopActiveTool();
    activeModify = new ol.interaction.Modify({ features: annotationsSelect.getFeatures() });
    map.addInteraction(activeModify);
});

document.getElementById('clearBtn').addEventListener('click', () => {
    Object.values(orderLayers).forEach((layer) => {
        const src = layer.getSource();
        src.getFeatures().filter((f) => f.get('annotation') === true).forEach((f) => src.removeFeature(f));
    });
    measureLayer.getSource().clear();
    orderHighlightLayer.getSource().clear();
    hidePopup();
    selectedAnnotationFeature = null;
    annotationsSelect.getFeatures().clear();
    stopActiveTool();
});

function computeArrowHead(start, end) {
    const [x1, y1] = start;
    const [x2, y2] = end;
    const dx = x2 - x1;
    const dy = y2 - y1;
    const len = Math.sqrt(dx * dx + dy * dy) || 1;
    const ux = dx / len;
    const uy = dy / len;
    const px = -uy;
    const py = ux;
    const size = Math.max(10, Math.min(18, len * 0.15));
    const half = size * 0.5;
    const tip = [x2, y2];
    const baseCenter = [x2 - ux * size, y2 - uy * size];
    const p1 = [baseCenter[0] + px * half, baseCenter[1] + py * half];
    const p2 = [baseCenter[0] - px * half, baseCenter[1] - py * half];
    return [tip, p1, p2, tip];
}

function enableDraw(drawType) {
    if (!annotationActive) return;
    stopActiveTool();
    annotationsSelect.getFeatures().clear();

    const source = getTargetSource();
    const groupId = `G_${Date.now()}_${Math.random().toString(16).slice(2)}`;

    if (drawType === 'Arrow') {
        let start = null;
        const first = (evt) => {
            start = evt.coordinate;
            map.un('singleclick', first);
            map.on('singleclick', second);
        };
        const second = (evt) => {
            const end = evt.coordinate;
            map.un('singleclick', second);
            map.getTargetElement().style.cursor = 'default';

            const line = new ol.geom.LineString([start, end]);
            const lineFeature = new ol.Feature(line);
            lineFeature.set('annotation', true);
            lineFeature.set('annotationLayer', getTargetLayerKey());
            lineFeature.set('shapeType', 'Arrow');
            lineFeature.set('annotationGroupId', groupId);

            const arrowHead = computeArrowHead(start, end);
            const poly = new ol.geom.Polygon([arrowHead]);
            const headFeature = new ol.Feature(poly);
            headFeature.set('annotation', true);
            headFeature.set('annotationLayer', getTargetLayerKey());
            headFeature.set('shapeType', 'Arrow');
            headFeature.set('annotationGroupId', groupId);

            source.addFeature(lineFeature);
            source.addFeature(headFeature);
        };

        map.on('singleclick', first);
        arrowHandlers.push({ handler: first });
        map.getTargetElement().style.cursor = 'crosshair';
        return;
    }

    const olDrawType = drawType === 'Text' ? 'Point' : drawType;
    if (drawType === 'Rectangle') {
        activeDraw = new ol.interaction.Draw({
            source,
            type: 'Circle',
            geometryFunction: ol.interaction.Draw.createBox()
        });
    } else {
        activeDraw = new ol.interaction.Draw({ source, type: olDrawType });
    }

    map.addInteraction(activeDraw);
    activeDraw.on('drawend', (e) => {
        const feature = e.feature;
        feature.set('annotation', true);
        feature.set('annotationLayer', getTargetLayerKey());
        feature.set('annotationGroupId', groupId);

        if (drawType === 'Text') {
            const label = prompt('Enter label text:', 'TRO');
            feature.set('labelText', label || '');
            feature.set('shapeType', 'Text');
        } else {
            feature.set('shapeType', drawType);
        }
    });
}

function enableMeasure(kind) {
    stopActiveTool();
    measureLayer.getSource().clear();

    measureTooltipEl = document.createElement('div');
    measureTooltipEl.style.position = 'absolute';
    measureTooltipEl.style.zIndex = 9999;
    measureTooltipEl.style.background = 'rgba(17,24,39,0.95)';
    measureTooltipEl.style.color = 'white';
    measureTooltipEl.style.borderRadius = '8px';
    measureTooltipEl.style.padding = '6px 10px';
    measureTooltipEl.style.fontSize = '12px';
    measureTooltipEl.style.whiteSpace = 'nowrap';
    measureTooltipEl.style.pointerEvents = 'none';
    measureTooltipEl.style.display = 'none';
    document.body.appendChild(measureTooltipEl);

    const formatLen = (line) => `${line.getLength().toFixed(1)} m`;
    const formatArea = (poly) => `${poly.getArea().toFixed(1)} m^2`;

    activeMeasure = new ol.interaction.Draw({
        source: measureLayer.getSource(),
        type: kind === 'distance' ? 'LineString' : 'Polygon'
    });
    map.addInteraction(activeMeasure);

    activeMeasure.on('drawstart', () => { measureTooltipEl.style.display = 'block'; });
    activeMeasure.on('drawend', () => { measureTooltipEl.style.display = 'none'; });
    activeMeasure.on('drawabort', () => { measureTooltipEl.style.display = 'none'; });

    activeMeasure.on('change:geometry', (e) => {
        const geom = e.target.getGeometry();
        if (!geom) return;
        const content = kind === 'distance' ? formatLen(geom) : formatArea(geom);
        const coord = geom.getLastCoordinate ? geom.getLastCoordinate() : geom.getInteriorPoint().getCoordinates();
        const pixel = map.getPixelFromCoordinate(coord);
        measureTooltipEl.textContent = content;
        measureTooltipEl.style.left = `${pixel[0] + 12}px`;
        measureTooltipEl.style.top = `${pixel[1] + 12}px`;
    });
}

// Tool button bindings
document.querySelectorAll('[data-draw]').forEach((btn) => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tool-btn').forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');
        enableDraw(btn.getAttribute('data-draw'));
    });
});
document.querySelectorAll('[data-measure]').forEach((btn) => {
    btn.addEventListener('click', () => enableMeasure(btn.getAttribute('data-measure')));
});

// -----------------------------
// Export/Import GeoJSON (annotations only)
// -----------------------------
const exportBtn = document.getElementById('exportBtn');
const importBtn = document.getElementById('importBtn');
const exportModal = document.getElementById('exportModal');
const importModal = document.getElementById('importModal');
const exportTextarea = document.getElementById('exportTextarea');
const importTextarea = document.getElementById('importTextarea');

function showModal(el) { el.classList.remove('hidden'); }
function hideModal(el) { el.classList.add('hidden'); }

function getAnnotationFeatures() {
    const features = [];
    Object.values(orderLayers).forEach((layer) => {
        layer.getSource().getFeatures().forEach((f) => {
            if (f.get('annotation') === true) features.push(f);
        });
    });
    return features;
}

function exportGeoJSON() {
    const format = new ol.format.GeoJSON();
    const features = getAnnotationFeatures();
    return format.writeFeaturesObject(features, { featureProjection: EPSG_27700, dataProjection: EPSG_27700 });
}

exportBtn.addEventListener('click', () => {
    exportTextarea.value = JSON.stringify(exportGeoJSON(), null, 2);
    showModal(exportModal);
});
document.getElementById('exportCloseBtn').addEventListener('click', () => hideModal(exportModal));
document.getElementById('copyExportBtn').addEventListener('click', async () => {
    try { await navigator.clipboard.writeText(exportTextarea.value); alert('Copied to clipboard.'); }
    catch (e) { alert('Copy failed. Copy manually.'); }
});

importBtn.addEventListener('click', () => { importTextarea.value = ''; showModal(importModal); });
document.getElementById('importCloseBtn').addEventListener('click', () => hideModal(importModal));

document.getElementById('doImportBtn').addEventListener('click', () => {
    const raw = importTextarea.value.trim();
    if (!raw) return alert('Paste GeoJSON first.');
    let obj = null;
    try { obj = JSON.parse(raw); } catch (e) { return alert('Invalid JSON.'); }

    const format = new ol.format.GeoJSON();
    let features = [];
    try {
        features = format.readFeatures(obj, { dataProjection: EPSG_27700, featureProjection: EPSG_27700 });
    } catch (e) {
        try {
            features = format.readFeatures(obj, { dataProjection: 'EPSG:4326', featureProjection: EPSG_27700 });
        } catch (e2) {
            return alert('Could not parse GeoJSON.');
        }
    }

    const target = getTargetSource();
    features.forEach((f) => {
        f.set('annotation', true);
        f.set('annotationLayer', getTargetLayerKey());
        f.set('shapeType', f.getGeometry().getType());
    });
    target.addFeatures(features);
    hideModal(importModal);
});

// Fullscreen (page element)
document.getElementById('fullscreenBtn').addEventListener('click', () => {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen?.();
    } else {
        document.exitFullscreen?.();
    }
    setTimeout(() => map.updateSize(), 100);
});

// -----------------------------
// Initialize the map
// -----------------------------
document.addEventListener('DOMContentLoaded', () => {
    fetchOrders();
});
