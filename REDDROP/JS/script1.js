const map = L.map('map').setView([31.46376, 74.44319], 16.5);
const tileURL = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>contributors, Coded by coder\'s gyan with ♥';

// const tiles = L.tileLayer(tileURL, { attribution }); //use when you host
const tiles = L.tileLayer(tileURL);

tiles.addTo(map);

const CLayer = L.circle([31.464222, 74.442593], { radius: 35, color: 'green' });
CLayer.addTo(map);
const CLayer1 = L.circle([31.463368, 74.443876], { radius: 20, color: 'brown' });
CLayer1.addTo(map);
// const bTrigleCoors = [
//     [
//         [31.465347, 74.442363]
//         [31.464105, 74.440677]
//         [31.462892, 74.444935]
//     ]
// ];
// const polygon = L.polygon(bTrigleCoors, { color: 'green' });
// polygon.addTo(map);
const latlngs = [
    [31.464931, 74.442845],
    [31.463848, 74.441447],
    [31.462750, 74.445165],
    [31.464081, 74.443851]
];

const polygon = L.polygon(latlngs, { color: 'coral' }).addTo(map);

const icon = L.icon({
    iconUrl: 'placeholder.png',
    iconSize: [35, 40]
});

const icon1 = L.icon({
    iconUrl: 'woods-marker.png',
    iconSize: [35, 35]
});

const icon2 = L.icon({
    iconUrl: 'fast-food.png',
    iconSize: [35, 40]
});

const marker = L.marker([31.464099, 74.443178], { icon });
const marker1 = L.marker([31.464413, 74.442587], { icon: icon1 });
const marker2 = L.marker([31.463597, 74.443963], { icon: icon2 });
marker.bindPopup('<a href="https://www.google.com/maps/place/Lahore+Garrison+University./@31.4646272,74.4422007,19z/data=!4m5!3m4!1s0x0:0xa6cc469044e1fbc1!8m2!3d31.4640061!4d74.4426299" target="_blank"><button class="btn btn-primary btn-small btn_size rounded-pill">Open Full Map</button></a>')
marker.bindTooltip('<span class="text-success"><b>Lahore Garrison University </b></span>').openTooltip();
marker1.bindTooltip('<span class="text-success"><b>Fountain Ground </b></span>').openTooltip();
marker2.bindTooltip('<span class="text-success"><b>LGU Cafe </b></span>').openTooltip();
marker1.addTo(map);
marker2.addTo(map);
marker.addTo(map);
L.control.scale().addTo(map);

// let map;

// function initMap() {
//     map = new google.maps.Map(document.getElementById("map1"), {
//         center: { lat: 28.70, lng: 77.10 },
//         zoom: 8,
//         mapTypeId: "terrain"
//     });
//     const marker = new google.maps.Marker({
//         position: { lat: 31.5204, lng: 74.3587 },
//         map: map,
//         label: "A",
//         title: " Lahore",
//         draggable: true,
//         animation: google.maps.Animation.DROP

//     });

//     const infoWindow = new google.maps.InfoWindow({
//         content: "<p>This is an info window</p>"
//     });
//     infoWindow.open(map, marker);
// }