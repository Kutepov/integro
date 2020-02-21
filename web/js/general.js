import {getLayerObjects,getLayersTree,getGeom,activateLayer} from './geoapi.js';
import {integroListCountries} from './geoapi.js';

//require('./geoapi.js');

const APIURL = 'http://10.246.127.177:8080/api';
const SERVICE = 'integro';
const PROJECTS_LAYER = 'world_projects';
const COUNTRIES_LAYER = 'world_boundary';
const API_KEY = 'my5cca9rm8bp56wxxh';

$(function(){
  $('#button_A').on('click', function(ev){getLayerObjects(PROJECTS_LAYER);});
  $('#button_B').on('click', function(ev){getLayersTree();});
  $('#button_C').on('click', function(ev){getLayers(PROJECTS_LAYER);});
  $('#button_D').on('click', function(ev){getLayer(PROJECTS_LAYER);});
  $('#button_E').on('click', function(ev){getLayerObjects2(COUNTRIES_LAYER);});
  
  $('#button_GEOMC').on('click', function(ev){integroSearchProject();});
  $('#button_GEOMP').on('click', function(ev){integroListProjects();});
  $('#button_GEOMR').on('click', function(ev){integroListCountries();});
  $('#button_GEOMQ').on('click', function(ev){integroFilterProject();});
  
  //$('#button_COUNTRIES').on('click', function(ev){activateLayer(COUNTRIES_LAYER);});
  //$('#button_PROJECTS').on('click', function(ev){activateLayer(PROJECTS_LAYER);});
});
