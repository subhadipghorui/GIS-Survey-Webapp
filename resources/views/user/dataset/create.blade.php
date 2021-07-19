@extends('layouts.backend.app')
@section('title')
    Dashboard
@endsection
@push('header')
<link rel="stylesheet" href="{{asset('assets/backend/openlayer6/ol.css')}}">
<style>
    #map{
        width: 100%;
        height: 88vh;
    }
    .geolocate {
        top: 100px;
        left: 0.5em;
      }
      /* On mobile */
      .ol-touch .geolocate {
        top: 120px;
      }
      .create-dataset{
        top: 130px;
        left: 0.5em;
      }
      /* On mobile */
      .ol-touch .create-dataset {
        top: 160px;
      }
      /******************** Pop up ***********************/
      .ol-popup {
        position: absolute;
        background-color: white;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #cccccc;
        bottom: 12px;
        left: -50px;
        min-width: 280px;
      }
      .ol-popup:after, .ol-popup:before {
        top: 100%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
      }
      .ol-popup:after {
        border-top-color: white;
        border-width: 10px;
        left: 48px;
        margin-left: -10px;
      }
      .ol-popup:before {
        border-top-color: #cccccc;
        border-width: 11px;
        left: 48px;
        margin-left: -11px;
      }
      .ol-popup-closer {
        text-decoration: none;
        position: absolute;
        top: 2px;
        right: 8px;
      }
      .ol-popup-closer:after {
        content: "✖";
      }
</style>
@endpush
@section('content')
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            <div class="row" id="fullscreen">
                <div id="map"></div>
                {{-- All Modals --}}
                <div class="all-modals">
                    <!-- Create Dataset Modal -->
                    <div class="modal fade" id="createDatasetModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header bg-primary text-light">
                                <h5 class="modal-title" id="staticBackdropLabel">Enter New Dataset</h5>
                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <div class="form-group">
                                        <label for="first_name" class="col-form-label">First Name:</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name" class="col-form-label">Last Name:</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="age" class="col-form-label">Age:</label>
                                        <input type="number" class="form-control" id="age" name="age">
                                    </div>
                                    <div class="form-group">
                                        <label for="dob" class="col-form-label">Date of Birth:</label>
                                        <input type="date" class="form-control" id="dob" name="dob">
                                    </div>
                                    <div class="form-group">
                                        <label for="latitude" class="col-form-label">Latitude</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude">
                                    </div>
                                    <div class="form-group">
                                        <label for="longitude" class="col-form-label">Longitude</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="createDatasetBtn">Submit</button>
                            </div>
                            </div>
                        </div>
                    </div><!-- ./Create Dataset Modal -->

                    <!-- Update Dataset Modal -->
                    <div class="modal fade" id="updateDatasetModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateDatasetModalLable" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header bg-info text-light">
                                <h5 class="modal-title" id="updateDatasetModalLable">Details</h5>
                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <div class="form-group" style="display: none">
                                        <input type="text" class="form-control" id="update_id" name="update_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="update_first_name" class="col-form-label">First Name:</label>
                                        <input type="text" class="form-control" id="update_first_name" name="update_first_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="update_last_name" class="col-form-label">Last Name:</label>
                                        <input type="text" class="form-control" id="update_last_name" name="update_last_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="update_age" class="col-form-label">Age:</label>
                                        <input type="number" class="form-control" id="update_age" name="update_age">
                                    </div>
                                    <div class="form-group">
                                        <label for="update_dob" class="col-form-label">Date of Birth:</label>
                                        <input type="date" class="form-control" id="update_dob" name="update_dob">
                                    </div>
                                    <div class="form-group">
                                        <label for="update_latitude" class="col-form-label">Latitude</label>
                                        <input type="text" class="form-control" id="update_latitude" name="update_latitude">
                                    </div>
                                    <div class="form-group">
                                        <label for="update_longitude" class="col-form-label">Longitude</label>
                                        <input type="text" class="form-control" id="update_longitude" name="update_longitude">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success mr-auto" id="updateDatasetBtn">Update</button>
                                <button type="button" class="btn btn-danger float-right" id="deleteDatasetBtn">Delete</button>
                            </div>
                            </div>
                        </div>
                    </div><!-- ./Update Dataset Modal -->

                    {{-- Popup --}}
                    <div id="popup" class="ol-popup">
                        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                        <div id="popup-content"></div>
                    </div>{{-- ./Popup --}}

                </div> {{-- ./All Modals --}}
            </div>
        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->
@endsection
@push('footer')
<script src="{{asset('assets/backend/openlayer6/ol.js')}}"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('assets/backend/gis/geojson.min.js')}}"></script>

<script>
////////////////////////////////////////////////////
// Initiate Map
    // Create a map obj
      let map = new ol.Map({
        target: 'map',
        layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        })
        ],
        view: new ol.View({
            center: [87.77625373840333, 22.9015625],
            zoom: 13,
            projection: "EPSG:4326"
            }),

        controls: new ol.control.defaults().extend([
            new ol.control.FullScreen({
                source: "fullscreen" // for redering modalas and other elements.
            }),
        ])
    });
    // map.on('click', function(evt){
    //     console.log(evt.coordinate);
    // })
///////////////////////////////////////////////////////
// Load data to map
    let vectorSource;
    let vectorLayer;
    let geojsonObject;

    // Vector Style

    // Polygon Style
    const fill = new ol.style.Fill({
    color: 'rgba(0,255,0,0.4)'
    });

    //  Line Style
    const stroke = new ol.style.Stroke({
        color: '#333',
        width: 1.25
    });

    /**
    * ol.style.Style({
    * image -> for points
    * stroke -> for lines
    * fill -> for ploygons
    * })
    */

    const styles = [
        new ol.style.Style({
            image: new ol.style.RegularShape({
                fill: fill,
                stroke: stroke,
                points: 3,  // sides 3 = triangle
                radius: 10
            }),
            fill: fill,
            stroke: stroke,
        })
    ];
    let datasets = axios.get('{{route("user.dataset.ajax")}}')
                    .then(function (response) {
                        geojsonObject = GeoJSON.parse(response.data.data, {Point: ['lat', 'lng']}); //https://github.com/caseycesari/geojson.js

                        // console.log(geojsonObject);

                        vectorSource = new ol.source.Vector({
                        features: new ol.format.GeoJSON().readFeatures(geojsonObject),
                        });

                        vectorLayer = new ol.layer.Vector({
                            source: vectorSource,
                            style: styles,
                            title: "Datasets",
                            zIndex: 999,

                        });
                        map.addLayer(vectorLayer);
                    })
                    .catch(function (error) {
                        console.log(error);
                    })


//////////////////////////////////////////////////////////
// Geolocation
    const geolocation = new ol.Geolocation({
    // enableHighAccuracy must be set to true to have the heading value.
        trackingOptions: {
            enableHighAccuracy: true
        },
        projection: map.getView().getProjection()
    });

    // ENABLE TRACKING
    geolocation.setTracking(true);

    // handle geolocation error.
    geolocation.on("error", function(error) {
        alert(error.message);
    });

    const accuracyFeature = new ol.Feature();
    geolocation.on("change:accuracyGeometry", function() {
        accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
    });

    const positionFeature = new ol.Feature();
    positionFeature.setStyle(
        new ol.style.Style({
            image: new ol.style.Circle({
                radius: 8,
                fill: new ol.style.Fill({
                    color: "#3399CC"
                }),
                stroke: new ol.style.Stroke({
                    color: "#fff",
                    width: 2
                })
            })
        })
    );
    geolocation.on("change:position", function() {
        const coordinates = geolocation.getPosition();
        positionFeature.setGeometry(
            coordinates ? new ol.geom.Point(coordinates) : null
        );
    });

    // Add the vector layer to map
    new ol.layer.Vector({
        map: map,
        source: new ol.source.Vector({
            features: [ accuracyFeature, positionFeature]
        }),
        zIndex: 0
    });

// //////////////////////////////////////////////////////////
// Control Geolocation
      let geolocateButton = document.createElement("button");
      geolocateButton.innerHTML = '<i class="fa fa-compass" aria-hidden="true"></i>';

      // Geolocate State
      let geolocateState = true;
      let handleGeolocate = function (e) {
        geolocation.setTracking(geolocateState);
        // alert("Tracking "+geolocateState);
        geolocateState = !geolocateState;
        map.setView(
          new ol.View({
            center: geolocation.getPosition(),
            zoom: 17,
            projection: "EPSG:4326",
          })
        );
      };

      geolocateButton.addEventListener("click", handleGeolocate, false);

      let geolocateElement = document.createElement("div");
      geolocateElement.className = "geolocate ol-selectable ol-control";
      geolocateElement.appendChild(geolocateButton);

      let GeolocateController = new ol.control.Control({
        element: geolocateElement,
      });
      map.addControl(GeolocateController);
/////////////////////////////////////////////////////////////////
// Create Dataset Button
      let button = document.createElement("button");
      button.innerHTML = '<i class="fa fa-user" aria-hidden="true"></i>';

      let handleCreateBtn = function (e) {
          // get the coordinate
        let coords = geolocation.getPosition();
        map.setView(
          new ol.View({
            center: geolocation.getPosition(),
            zoom: 14,
            projection: "EPSG:4326",
          })
        );

        // Open The Create Form
        $('#createDatasetModal').modal('show');

        // Push the coordinate to the modal
        $('#createDatasetModal').on('shown.bs.modal', function (event) {
            var modal = $(this)
            modal.find('.modal-body input#latitude').val(coords[1]);
            modal.find('.modal-body input#longitude').val(coords[0]);
        });
      };

      button.addEventListener("click", handleCreateBtn, false);

      var element = document.createElement("div");
      element.className = "create-dataset ol-selectable ol-control";
      element.appendChild(button);

      var CreateDatasetController = new ol.control.Control({
        element: element,
      });
      map.addControl(CreateDatasetController);

/////////////////////////////////////////////////////////////////////
// Popup

    // Elements that make up the popup.
        const popupContainer = document.getElementById('popup');
        const popupContent = document.getElementById('popup-content');
        const popupCloser = document.getElementById('popup-closer');

    // Create an overlay to anchor the popup to the map.
        const popupOverlay = new ol.Overlay({
        element: popupContainer,
        autoPan: true,
        autoPanAnimation: {
                duration: 250,
            },
        });

    /**
    * Add a click handler to hide the popup.
    * @return {boolean} Don't follow the href.
    */
    popupCloser.onclick = function () {
            popupOverlay.setPosition(undefined);
            popupCloser.blur();
            return false;
        };
    map.addOverlay(popupOverlay);
    /*************************************
    * Map events
    * https://openlayers.org/en/latest/apidoc/module-ol_MapBrowserEvent-MapBrowserEvent.html
    **************************************/
    map.on('pointermove', function (evt) {
        var features = [];
        map.forEachFeatureAtPixel(evt.pixel,
        function(feature, layer) {
            return features.push(feature);
        });
        // TOp most feature
        // console.log(features);
        let feature = features[0];
        if (feature) {
            let geometry = feature.getGeometry();
            let coord = geometry.getCoordinates();

            const coordinate = coord;
            const hdms = ol.coordinate.toStringHDMS(coordinate);

            let htmlContent = `
                <div class="px-2 py-1">
                    <div class="row">
                        <label for="name" class="col-sm-4 col-form-label">Name:</label>
                        <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="name" value="${feature.get('first_name')} ${feature.get('last_name')}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="age" class="col-sm-4 col-form-label">Age:</label>
                        <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="age" value="${feature.get('age')}">
                        </div>
                    </div>
                </div>
            `;
            popupContent.innerHTML = htmlContent;
            popupOverlay.setPosition(coord);
            // console.log(feature);
        }
    });
    map.on('dblclick', function (evt) {
        var features = [];
        map.forEachFeatureAtPixel(evt.pixel,
            function(feature, layer) {
                return features.push(feature);
            });
        // TOp most feature
        console.log(features);
        let feature = features[0];
        if (feature) {
            let geometry = feature.getGeometry();
            let coord = geometry.getCoordinates();

            const coordinate = coord;
            const hdms = ol.coordinate.toStringHDMS(coordinate);

            // Update Modal Show
            // Open The Create Form
            $('#updateDatasetModal').modal('show');

            // Push the coordinate to the modal
            $('#updateDatasetModal').on('shown.bs.modal', function (event) {
                var modal = $(this)
                modal.find('.modal-body input#update_id').val(feature.get('id'));
                modal.find('.modal-body input#update_first_name').val(feature.get('first_name'));
                modal.find('.modal-body input#update_last_name').val(feature.get('last_name'));
                modal.find('.modal-body input#update_age').val(feature.get('age'));
                modal.find('.modal-body input#update_dob').val(feature.get('dob'));
                modal.find('.modal-body input#update_latitude').val(coord[1]);
                modal.find('.modal-body input#update_longitude').val(coord[0]);
            });
            console.log(feature.getProperties());
        };

    });

</script>
<script>
// Api Crud

/////////////////////////////////////////////////////////
// Create Dataset
    let createDatasetBtn = document.getElementById('createDatasetBtn');

    createDatasetBtn.addEventListener('click', function(){
        // Get all the form data
        let first_name = document.getElementById('first_name');
        let last_name = document.getElementById('last_name');
        let age = document.getElementById('age');
        let dob = document.getElementById('dob');
        let latitude = document.getElementById('latitude');
        let longitude = document.getElementById('longitude');
        // post dataset
        let postData = {
            first_name: first_name.value,
            last_name:last_name.value,
            age: age.value,
            dob: dob.value,
            lat: latitude.value,
            lng: longitude.value
        }
        console.log(postData);
        axios.post('{{route("user.dataset.store")}}', postData)
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });

        // Reset Form
            first_name.value=null,
            last_name.value=null,
            age.value=null,
            dob.value=null,
            latitude.value=null,
            longitude.value=null
        // close modal
        $('#createDatasetModal').modal('hide');
        // Remove the layer & Update it
        map.removeLayer(vectorLayer);
        axios.get('{{route("user.dataset.ajax")}}')
                .then(function (response) {
                    geojsonObject = GeoJSON.parse(response.data.data, {Point: ['lat', 'lng']}); //https://github.com/caseycesari/geojson.js

                    console.log(geojsonObject);

                    vectorSource = new ol.source.Vector({
                    features: new ol.format.GeoJSON().readFeatures(geojsonObject),
                    });

                    vectorLayer = new ol.layer.Vector({
                        source: vectorSource,
                        style: styles,
                        title: "Datasets",
                        zIndex: 999,
                    });
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function(){
                    map.addLayer(vectorLayer);
                })

    });
/////////////////////////////////////////////////////////////
// Update Dataset
    let updateDatasetBtn = document.getElementById('updateDatasetBtn');

    updateDatasetBtn.addEventListener('click', function(){
        // Get all the form data
        let id = document.getElementById('update_id');
        let first_name = document.getElementById('update_first_name');
        let last_name = document.getElementById('update_last_name');
        let age = document.getElementById('update_age');
        let dob = document.getElementById('update_dob');
        let latitude = document.getElementById('update_latitude');
        let longitude = document.getElementById('update_longitude');
        // post dataset
        let updateData = {
            id: id.value,
            first_name: first_name.value,
            last_name:last_name.value,
            age: age.value,
            dob: dob.value,
            lat: latitude.value,
            lng: longitude.value
        }
        console.log(updateData);
        axios.put(`{{route("user.dataset.update")}}`, updateData)
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });

        // Reset Form
            first_name.value=null,
            last_name.value=null,
            age.value=null,
            dob.value=null,
            latitude.value=null,
            longitude.value=null
        // close modal
        $('#updateDatasetModal').modal('hide');
        // Remove the layer & Update it
        map.removeLayer(vectorLayer);
        axios.get('{{route("user.dataset.ajax")}}')
                .then(function (response) {
                    geojsonObject = GeoJSON.parse(response.data.data, {Point: ['lat', 'lng']}); //https://github.com/caseycesari/geojson.js

                    console.log(geojsonObject);

                    vectorSource = new ol.source.Vector({
                    features: new ol.format.GeoJSON().readFeatures(geojsonObject),
                    });

                    vectorLayer = new ol.layer.Vector({
                        source: vectorSource,
                        style: styles,
                        title: "Datasets",
                        zIndex: 999,
                    });
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function(){
                    map.addLayer(vectorLayer);
                })

    })

//////////////////////////////////////////////////////////////////
// Delete Dataset
    let deleteDatasetBtn = document.getElementById('deleteDatasetBtn');

    deleteDatasetBtn.addEventListener('click', function(){
        // Get all the form data
        let id = document.getElementById('update_id');
        // post dataset
        let updateData = {
            id: id.value,
        }
        console.log(updateData);
        axios.post(`{{route("user.dataset.destroy")}}`, updateData)
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });

        // Reset Form
            id.value = null;
            first_name.value=null,
            last_name.value=null,
            age.value=null,
            dob.value=null,
            latitude.value=null,
            longitude.value=null
        // close modal
        $('#updateDatasetModal').modal('hide');
        // Remove the layer & Update it
        map.removeLayer(vectorLayer);
        axios.get('{{route("user.dataset.ajax")}}')
                .then(function (response) {
                    geojsonObject = GeoJSON.parse(response.data.data, {Point: ['lat', 'lng']}); //https://github.com/caseycesari/geojson.js

                    console.log(geojsonObject);

                    vectorSource = new ol.source.Vector({
                    features: new ol.format.GeoJSON().readFeatures(geojsonObject),
                    });

                    vectorLayer = new ol.layer.Vector({
                        source: vectorSource,
                        style: styles,
                        title: "Datasets",
                        zIndex: 999,
                    });
                    map.addLayer(vectorLayer);
                })
                .catch(function (error) {
                    console.log(error);
                })

    })
</script>
@endpush
