var baseLayers = {
    "OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),
    "CartoDB Positron": L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png'),
    "Darkmap": L.tileLayer('https://cartodb-basemaps-b.global.ssl.fastly.net/spotify_dark/{z}/{x}/{y}{r}.png')
};

var mymap = L.map('map').setView([14.18, 108.84], 5);
baseLayers["OpenStreetMap"].addTo(mymap);

L.control.layers(baseLayers).addTo(mymap);
L.control.scale({
    metric: true,
    imperial: false,
    position: 'bottomleft',
    maxWidth: 150
}).addTo(mymap);

var miniMapLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    minZoom: 0,
    maxZoom: 13
});

var miniMap = new L.Control.MiniMap(miniMapLayer).addTo(mymap);


var thuadat = L.tileLayer.betterWms("http://localhost:8080/geoserver/First_Workspace/wms", {
    layers: 'First_Workspace:nha_q10',
    format: 'image/png',
    transparent: true,
    tiled: true
})

thuadat.addTo(mymap);

// Lấy tham chiếu đến checkbox
var checkboxThuadat = document.getElementById('switchLayerThuadat');

// Lắng nghe sự kiện "change" trên checkbox
checkboxThuadat.addEventListener('change', function() {
    if (this.checked) {
        // Nếu checkbox được chọn (checked), thêm layer vào bản đồ
        if (!mymap.hasLayer(thuadat)) {
            mymap.addLayer(thuadat);
        }
    } else {
        // Nếu checkbox không được chọn, xóa layer khỏi bản đồ
        if (mymap.hasLayer(thuadat)) {
            mymap.removeLayer(thuadat);
        }
    }
});

