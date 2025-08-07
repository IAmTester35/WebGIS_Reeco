// Tạo một đối tượng chứa các tilemap khác nhau
var baseLayers = {
    "OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }),
    "CartoDB Positron": L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
    }),
    "Darkmap": L.tileLayer('https://cartodb-basemaps-b.global.ssl.fastly.net/spotify_dark/{z}/{x}/{y}{r}.png', {
        attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    })
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