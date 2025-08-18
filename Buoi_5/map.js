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

async function fetchAndDisplayMarkers() {
    try {
        // Gửi yêu cầu đến file PHP
        const response = await fetch('http://localhost:8000/vd.php');
        
        // Kiểm tra xem yêu cầu có thành công không
        if (!response.ok) {
            throw new Error(`Lỗi HTTP: ${response.status}`);
        }

        // Chuyển đổi dữ liệu nhận được thành JSON
        const locations = await response.json();

        // Kiểm tra nếu dữ liệu có lỗi
        if (locations.error) {
            console.error('Lỗi từ server:', locations.error);
            return;
        }

        // Duyệt qua mảng dữ liệu và thêm marker vào bản đồ
        locations.forEach(location => {
            const lat = parseFloat(location.latitude);
            const lon = parseFloat(location.longitude);
            const id = location.id;

            // Kiểm tra nếu tọa độ hợp lệ
            if (!isNaN(lat) && !isNaN(lon)) {
                L.marker([lat, lon])
                    .addTo(mymap)
                    .bindPopup(`<b>ID:</b> ${id}<br><b>Vĩ độ:</b> ${lat}<br><b>Kinh độ:</b> ${lon}`)
                    .openPopup();
            }
        });

    } catch (error) {
        console.error('Lỗi khi lấy dữ liệu tọa độ:', error);
    }
}

fetchAndDisplayMarkers();