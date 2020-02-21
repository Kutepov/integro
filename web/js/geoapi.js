/*
* api/v1/{service}/ layers/{layer}/objects
'https://example.rusgis.com/api/v1/test_register/layers/ entity_type_layer/objects?page=1&pageSize=20' -i \ -H 'Accept: application/json;charset=UTF-8'

api/v1/geoportal/{service}/layers/sections
'https://example.rusgis.com/api/v1/geoportal /test_register/layers/sections' -i \ -H 'Accept: application/json;charset=UTF-8'

api/v1/geoportal/{service}/layers

api/v1/geoportal/{service}/layers/{lyrCodeName}

• geoportalApi
• activateLayer(service, layerCodeName

api/v1/{service}/ layers/{layer}/objects
*/

import * as config from 'js/config.js';

//api/v1/services/{codeName}/model/{entityType}/objects
/*codeName - кодовое наименование сервиса;
entityType – кодовое наименование класса объектов;
id - Идентификатор объекта. При создании не указывается;
name - Наименование объекта;
guid - Глобальный уникальный идентификатор объекта. При создании не указывается;
entityType - Класс объектов, которому принадлежит объект;
status - Состояние объекта. Может быть 0 - действующий, 1 - не актуальный, 2 – исторический;
parentId - Идентификатор родителя объекта, если объект исторический;
metadata - Контейнер с описанием метаданных объекта класса объектов. При создании не указываются;
attributes - Массив с описанием атрибутов объекта;
attachments - Массив с описанием привязанных файлов.
*/

// API Integro
function integroListProjects() 
{
  $.get(
    config.INTEGROURL + '/countries/'+country_id+'/projects/',
    { },
    function(data) {
      console.log(data);
      //$('#input_AB').text(JSON.stringify(data));
    }    
  );
}

function integroListCountries()
{
  $.get(
    config.INTEGROURL + '/countries',
    { 
      "page" : 1,  "count" : 10,      
    },
    function(data) {
       console.log(data);
       //$('#input_AB').text(JSON.stringify(data));
    }    
  );
}


export function integroGetProjectLinked(country_id, linked_id, callback) 
{
  $.get(
    config.INTEGROURL + '/countries/'+country_id+'/projects/linked/'+linked_id,
    function(data) {
      //console.log(data);
      //$('#input_AB').text(JSON.stringify(data));
      if(callback != undefined && callback != null)
        //callback($.parseJSON(data.responseText));
        callback(data);
      return data;
    }    
  );
}


export function integroNextProject(country_id, project_id, callback) 
{
  $.get(
    config.INTEGROURL + '/countries/'+country_id+'/projects/next/'+project_id,
    function(data) {
      if(callback != undefined && callback != null)
        callback(data);
      return data;
    }    
  );
}

export function integroPrevProject(country_id, project_id, callback) 
{
  $.get(
    config.INTEGROURL + '/countries/'+country_id+'/projects/prev/'+project_id,
    function(data) {
      if(callback != undefined && callback != null)
        callback(data);
      return data;
    }    
  );
}


export function integroGetProject(country_id, project_id, callback) 
{
  $.get(
    config.INTEGROURL + '/countries/'+country_id+'/projects/'+project_id,
    function(data) {
      //console.log(data);
      //$('#input_AB').text(JSON.stringify(data));
      if(callback != undefined && callback != null)
        callback(data);
      return data;
    }    
  );
}

export function integroLinkProject(project_id, linked_id, callback)
{
  $.ajax({
    url: config.INTEGROURL + '/countries/projects',
    method: "POST",
    //xhrFields: { withCredentials: true },
    //crossDomain: true,
    data: { 
      "pid" : project_id,
      "linked_id" : linked_id,      
    },
    success: function(data, textStatus, jqXHR) {
      console.log(data);
      //$('#input_AB').text(JSON.stringify(data));
      //dialogLink.dialog( "close" );
      if(callback != undefined && callback != null)
        callback(data);
      return data;
    }    
  });
}

//--------------------------------------------
// API GIP
function createLayerObject2(layer, geom, name)
{
  var url = config.APIURL + '/services/' + config.SERVICE + '/model/'+layer+'/objects';  
  $.ajax({
    type: "POST",
    //async: false,
    //contentType: "application/json",
    headers: config.API_HEADER,
    url: url,
    dataType: "json",
    contentType: "application/json;charset=utf-8",
    data: JSON.stringify(
      { 
      //"id":"null",
      "name" : name,
      "entityType" : null,
      "parentId" : null,
      "status" : 0,
      //"geometry" : geom,
      "attributes" : {
        "geom" : geom,        
        "entitytype":layer,
        "status":0,
        "name":"Монголия проект 2",
        "project_id":"2",
        "project_type_id__id":2,
        "project_type_id":2        
      },      
    }),
    complete: function(data) {
      console.log(data);
      //$('#input_AB').text(JSON.stringify(data));
    }    
  });
}

/*
{ "codeName" : "project_id", "value" : "2" }, { "codeName" : "project_type_id", "value" : "2" } 
  "entitytype":"world_projects",
        "status":0,
        "id":3,
        "name":"Монголия проект 1",
        "project_id":"2",
{
  "type":"FeatureCollection",
  "totalFeatures":"unknown",
  "features":[
  {
    "type":"Feature",
    "id":"world_projects.3",
    "geometry":{
      "type":"MultiPoint",
      "coordinates":[[1.127223981058923E7,5617254.88331259]]},
      "geometry_name":"geom",
      "properties":{
        "entitytype":"world_projects",
        "status":0,
        "id":3,
        "name":"Монголия проект 1",
        "project_id":"2",
        "project_type_id__id":2,
        "project_type_id":"{
          \"entitytype\":\"project_type_ref\",
          \"name\":\"Бизнес идея\",
          \"id\":2,
          \"status\":0
         }",
         "bbox":[1.127223981058923E7,5617254.88331259,1.127223981058923E7,5617254.88331259]
       }
     }
   ],
   "crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::3857"}},
   "bbox":[1.127223981058923E7,5617254.88331259,1.127223981058923E7,5617254.88331259]}
*/

//api/v1/geoportal/{service}/{codeName}/objects
/*service - кодовое наименование сервиса;
codeName – кодовое наименование слоя;
name - Наименование объекта;
status - Статус объекта;
geometry - Описание геометрии объекта;
*/

export function createLayerObject(layer, geom, name, props, callback)
{
  /*
  props = {
    project_id
    project_type_id    
  }
  
  props = {
    id
    name
    desc_intgr    
  }
  */
  var url = config.APIURL + '/geoportal/' + config.SERVICE + '/'+ layer +'/objects';
  $.ajax({
    headers: config.API_HEADER,
    type: "POST",
    url: url,
    dataType: "json",
    contentType: "application/json;charset=utf-8",
    data: JSON.stringify({ 
      "name" : name,
      "status" : 0,
      "geometry" : JSON.stringify(geom),
      "attributes" : [],
      "attachments": []      
    }),
    complete: function(data) {   
console.log(data);  
      if(callback != undefined && callback != null)
        callback(data);
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


//api/v1/geoportal/{service}/{codeName}/objects
export function getLayerObject(layer, id, callback)
{
  $.get(
    $.extend( {}, config.API_OPTIONS, {
      url: config.APIURL + '/geoportal/' + config.SERVICE + '/' + layer + '/objects/',
      data: { 
        cql: 'id='+id,
        sortBy: id   
      },
      success: function(data) {
        console.log(data);
        if(callback != undefined && callback != null) {
          callback(data);
        }
      }
    })    
  );
}
 
//api/v1/geoportal/{service}/{codeName}/objects/{id}/geom
export function getGeom(layer, id, callback)
{  
  $.get(
    $.extend( {}, config.API_OPTIONS, {
      url: config.APIURL + '/geoportal/' + config.SERVICE + '/' + layer + '/objects/' + id + '/geom',          
      success: function(data) {
        console.log(data);
        //$('#input_AB').text(JSON.stringify(data));
        if(callback != undefined && callback != null)
          callback(data);
      }
    })    
  );   
  //api/v1/geoportal/{service}/{codeName}/objects/{id}/geom
  //api/v1/services/{codeName} /model/{entityType} /objects/{guid}
}

//api/v1/{service}/ layers/{layer}/objects
function getLayerObjects(layer)
{
  $.get(
    $.extend( {}, config.API_OPTIONS, {
      url: config.APIURL + '/' + config.SERVICE + '/layers/'+layer+'/objects',
      data: { page: 1, pageSize: 20 },
      success: function(data) {
        console.log(data);
        $('#input_AB').text(JSON.stringify(data));
      }
    })    
  );
}

//api/v1/geoportal/{service}/layers/sections
function getLayersTree()
{
  $.get(
    $.extend( {}, config.API_OPTIONS, {
      url: config.APIURL + '/geoportal/' + config.SERVICE + '/layers/sections',
      success: function(data) {
        console.log(data);
        $('#input_AB').text(JSON.stringify(data));
      } 
    })   
  );
}

//api/v1/geoportal/{service}/layers
function getLayers(layer)
{
  //X-API-Key: my5cca9rm8bp56wxxh
  $.get(
    $.extend( {}, config.API_OPTIONS, {
      url: config.APIURL + '/geoportal/' + config.SERVICE + '/layers',
      data: { codeNames: layer },    
      success: function(data) {
        console.log(data);
        $('#input_AB').text(JSON.stringify(data));
      }
    })    
  )
}

//api/v1/geoportal/{service}/layers/{lyrCodeName}
function getLayer(layer)
{
  $.get(
    $.extend( {}, config.API_OPTIONS, {
      url: config.APIURL + '/geoportal/' + config.SERVICE + '/layers/' + layer,    
      success: function(data) {
        console.log(data);
        $('#input_AB').text(JSON.stringify(data));
      }
    })    
  )
}