const APIURL = 'http://10.246.127.177:8080/api';
//const APIURL = 'http://10.246.127.173:8080/api';
const SERVICE = 'integro';
const PROJECTS_LAYER = 'world_projects';
const COUNTRIES_LAYER = 'world_boundary';
const API_KEY = 'my5cca9rm8bp56wxxh';

(function(){
  $('#button_A').on('click', function(ev){getLayerObjects(PROJECTS_LAYER);});
  $('#button_B').on('click', function(ev){getLayersTree();});
  $('#button_C').on('click', function(ev){getLayers(PROJECTS_LAYER);});
  $('#button_D').on('click', function(ev){getLayer(PROJECTS_LAYER);});
  $('#button_E').on('click', function(ev){getLayerObjects2(COUNTRIES_LAYER);});
  
  $('#button_GEOMC').on('click', function(ev){getGeom(PROJECTS_LAYER);});
  $('#button_GEOMP').on('click', function(ev){getGeom(COUNTRIES_LAYER);});
  
  $('#button_COUNTRIES').on('click', function(ev){activateLayer(COUNTRIES_LAYER);});
  $('#button_PROJECTS').on('click', function(ev){activateLayer(PROJECTS_LAYER);});

  $.ajaxSetup({
    headers:{ 'X-API-Key': API_KEY }
  });

  //http://10.246.127.177:8080/gis/gwc/service/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&FORMAT=image%2Fpng&TRANSPARENT=true&LAYERS=master%3ABaseMap_RZD&STYLE=&WIDTH=256&HEIGHT=256&SRS=EPSG%3A3857&STYLES=&BBOX=3757032.814272985%2C7514065.628545966%2C4070118.8821290666%2C7827151.696402048
  //http://10.246.127.177:8080/gis/gwc/service/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&FORMAT=image%2Fpng&TRANSPARENT=true&LAYERS=master%253ABaseMap_RZD&WIDTH=256&HEIGHT=256&SRS=EPSG%3A3857&STYLES=&BBOX=7514065.628545966%2C2504688.542848654%2C10018754.171394622%2C5009377.08569731
  
  /*
  http://10.246.127.177:8080/gis/gwc/service/wms?
  SERVICE=WMS&
  VERSION=1.1.1&
  REQUEST=GetMap&
  FORMAT=image%2Fpng&
  TRANSPARENT=true&
  LAYERS=master%3ABaseMap_RZD&
  STYLE=&
  WIDTH=256&HEIGHT=256&
  SRS=EPSG%3A3857&
  STYLES=&
  BBOX=2504688.542848654%2C6261721.357121639%2C3757032.814272982%2C7514065.628545967
  */
    var config = {
        service: SERVICE, //null,
        //layersConfig: null, // 
        layersConfig: { 
          defaultLayers: [COUNTRIES_LAYER,PROJECTS_LAYER], 
          requiredLayers: [COUNTRIES_LAYER,PROJECTS_LAYER], 
          mainLayers: [PROJECTS_LAYER] 
        },
        homeCenter: [38, 57], // например, [38, 57]
        homeZoom: 7, // например, 7
        workSetFitDisabled: false,
        workSetId: null, // например, 123
        //interfaceConfig: null, // { isStatusBarHidden: null, isMainToolbarHidden: null, hiddenTools: null }
        interfaceConfig: { 
          isStatusBarHidden: false, 
          isMainToolbarHidden: false, 
          hiddenTools: ['TOPOLOGY','SWIPE','PLUGINS','WORKING_SETS','ANALYTICS_HEATMAP','ROUTING','AVAILABLE_ZONES',
          'ANALYTIC_LAYERS','INTERPOLATION','TIMED_LAYERS','TRAFFIC_LAYER','CREATE_USER_LAYER','POINT_SEARCH',
          'SPATIAL_SEARCH','ATTRIBUTIVE_SEARCH'] 
        },
        //lightConfig: {          isLight: true        },
    };

    //var geoJSONGeometry = JSON.parse('{"type":"MultiPolygon","coordinates":[[[[7299286.949504229,7789670.614572813],[7295312.2240333995,7785543.015045414],[7299898.44573051,7782103.348772581],[7303682.078630626,7787492.159266686],[7299286.949504229,7789670.614572813]]]],"crs":{"type":"name","properties":{"name":"EPSG:3857"}}}');
    //var GeoJSON = JSON.parse('{"type":"FeatureCollection","totalFeatures":"unknown","features":[{"type":"Feature","id":"asdfgsdfgsfg.2","geometry":{"type":"MultiPolygon","coordinates":[[[[4176031.56299061,7510473.83322405],[4191801.96148036,7516403.08428624],[4192368.86711918,7504992.04136543],[4176031.56299061,7510473.83322405]]]]},"geometry_name":"geom","properties":{"entitytype":"adm_area","id":2,"name":"Центральный административный округ","status":0,"area_test":18,"short_name_test":"Центральный АО","ident":2,"city":"Москва","number_district":"10"}}],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::3857"}}}');
    //var JSONFields = JSON.parse(' [{"codeName":"area_test","name":"Площадь","fieldType":"NUMERIC","nameField":false,"excluded":false,"searchField":true,"multiple":false,"required":false,"editable":true},{"codeName":"city","name":"Город","fieldType":"STRING","nameField":false,"excluded":false,"searchField":true,"multiple":false,"required":false,"editable":true},{"codeName":"ident","name":"Идентификатор","fieldType":"NUMERIC","nameField":false,"excluded":false,"searchField":true,"multiple":false,"required":false,"editable":true},{"codeName":"number_district","name":"Количество районов (поселений)","fieldType":"STRING","nameField":false,"excluded":false,"searchField":true,"multiple":false,"required":false,"editable":true},{"codeName":"short_name_test","name":"Краткое наименование","fieldType":"STRING","nameField":false,"excluded":false,"searchField":true,"multiple":false,"required":false,"editable":true}]');

    function startGeoportal() {
      GeoportalApi.init("gp", config);
      /*GeoportalApi.ready = function () {
          GeoportalApi.getExtent("EPSG:4326", function (extent) { console.log("Экстент получен: " + extent); });
          GeoportalApi.updateMapSize();
          // включить слой. Параметры: кодовое имя сервиса, кодовое имя слоя
          //GeoportalApi.activateLayer(SERVICE, COUNTRIES_LAYER);
          //GeoportalApi.activateLayer(SERVICE, PROJECTS_LAYER);
          // Выключить все слои
          //GeoportalApi.unselectAllLayers();
          // Показать объект. Параметры: кодовое имя сервиса, кодовое имя слоя, идентификатор объекта
          //GeoportalApi.showObject("admin", "zu_test", 72);
          GeoportalApi.currentObject(function (object) { console.log("Текущий объект: " + JSON.stringify(object)); });
          // Показать геометрию. Параметры: GeoJSON геометрии, кодовое имя стиля, режим редактирования
          //GeoportalApi.showGeometry(geoJSONGeometry, "new_style0041", true);
          //GeoportalApi.clearGeometry();
          // Показать внешний объект. Параметры: JSON c описанием атрибутов объекта, GeoJSON с геометрией, кодовое имя стиля
          //GeoportalApi.showExternalObject(JSONFields, GeoJSON, "new_style0041");
          GeoportalApi.onMapClick = function (coordinate, srCode) { console.log("Координата клика: [" + coordinate + "] в СК " + srCode); }
          GeoportalApi.onIdentifyObject = function (object) { console.log("Идентифицирован объект: " + JSON.stringify(object)); }
          GeoportalApi.onClearObject = function () { console.log("Объект закрыт"); }
      };*/
    }
    startGeoportal();
})();



function createLayerObject2(layer, geom, name)
{
  var url = APIURL + '/geoportal/' + SERVICE + '/'+layer+'/objects';
  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    contentType: "application/json;charset=utf-8",
    data: JSON.stringify({
      "id": null, 
      "name" : name,
      "status" : 0,
      "geometry" : geom,
      "attributes" : {           
        "entitytype":layer,
        "status":0,
        "name":"Монголия проект 2",
        "project_id":"2",
        "project_type_id__id":2,
        "project_type_id":2        
      },
      attachments: {}      
    }),
    complete: function(data) {
       console.log(data);
       //$('#input_AB').text(JSON.stringify(data));
    }    
  });
}


//export default {createLayerObject};

//api/v1/geoportal/{service}/{codeName}/objects
/*service - кодовое наименование сервиса;
codeName – кодовое наименование слоя;
name - Наименование объекта;
status - Статус объекта;
geometry - Описание геометрии объекта;
*/

function _createLayerObject(layer, geom, name)
{
  $.post(
    APIURL + '/' + SERVICE + '/'+layer+'/model/'+layer+'/objects',
    { 
      "name" : name,
      "entityType" : null,
      "parentId" : null,
      "status" : 0,
      "attributes" : {
        "geom" : geom,
      }
    },
    function(data) {
       console.log(data);
       //$('#input_AB').text(JSON.stringify(data));
    }    
  );
}
//export createLayerObject;

//api/v1/{service}/ layers/{layer}/objects
function getLayerObjects(layer)
{
  $.get(
    APIURL + '/' + SERVICE + '/layers/'+layer+'/objects',
    { page: 1, pageSize: 20 },
    function(data) {
       console.log(data);
       $('#input_AB').text(JSON.stringify(data));
    }    
  );
}

//api/v1/geoportal/{service}/layers/sections
function getLayersTree()
{
  $.get(
    APIURL + '/geoportal/' + SERVICE + '/layers/sections',
    function(data) {
       console.log(data);
       $('#input_AB').text(JSON.stringify(data));
    }    
  );
}

//api/v1/geoportal/{service}/layers
function getLayers(layer)
{
  //X-API-Key: my5cca9rm8bp56wxxh
  $.get(
    APIURL + '/geoportal/' + SERVICE + '/layers',
    { codeNames: layer },    
    function(data) {
       console.log(data);
       $('#input_AB').text(JSON.stringify(data));
    }    
  )
}

//api/v1/geoportal/{service}/layers/{lyrCodeName}
function getLayer(layer)
{
  $.get(
    APIURL + '/geoportal/' + SERVICE + '/layers/' + layer,    
    function(data) {
       console.log(data);
       $('#input_AB').text(JSON.stringify(data));
    }    
  )
}

//api/v1/geoportal/{service}/{codeName}/objects
function getLayerObjects2(layer)
{
  $.get(
    APIURL + '/geoportal/' + SERVICE + '/'+layer+'/objects',
    {},
    function(data) {
       console.log(data);
       $('#input_AB').text(JSON.stringify(data));
    }    
  )
}
 
//api/v1/geoportal/{service}/{codeName}/objects/{id}/geom

function getGeom(layer)
{
  //GeoportalApi.unselectAllLayers();
  //GeoportalApi.activateLayer(SERVICE, layer);
  
  //GeoportalApi.onIdentifyObject = function (object) {
    //console.log("Идентифицирован объект: " + JSON.stringify(object));
    //object.name
    //object.geometry.coordinates
    //for (var prop in object.properties[10]) {
      //if (prop.field.codeName != undefined && prop.field.codeName == 'id') {
        //var id = prop.field.value;
        var id = $('#input_OBJ').val();
        $.get(
          APIURL + '/' + SERVICE + '/' + layer + '/objects/' + id + '/geom',          
          function(data) {
             console.log(data);
             $('#input_AB').text(JSON.stringify(data));
          }    
        );   
        //break; 
      //}
    //}    
  //}
  //api/v1/geoportal/{service}/{codeName}/objects/{id}/geom
  //api/v1/services/{codeName} /model/{entityType} /objects/{guid}
}

function activateLayer(layer)
{
  GeoportalApi.unselectAllLayers();
  GeoportalApi.activateLayer(SERVICE, layer);
  
  GeoportalApi.onIdentifyObject = function (object) {
    console.log("Идентифицирован объект: " + JSON.stringify(object));
    //object.name
    //object.geometry.coordinates
    switch(object.entityType){
      case "countries":
        GeoportalApi.showGeometry(object.geometry, null, true);
      break;
      case "world_projects":
        //homeCenter:number[] – координаты [X, Y] для центрирования карты;
        GeoportalApi.homeZoom = 12;
        GeoportalApi.showGeometry(object.geometry, null, true);
        console.log("Координаты объект: " + JSON.stringify(object.geometry));
      break;
    }
  }

  //currentObject(callback) - вернуть идентифицированный или открытый при помощи метода showObject объект
  // callback:function(object) – функция, в которую будет передан объект Object, идентификация которого выполнена в данный момент. Свойства объекта:
  // geometry — геометрия в GeoJSON;
  // srCode — код системы координат объекта;
  // properties[] — массив атрибутов объекта.
}
