import * as config from './config.js';
import {getGeom, getLayerObject, createLayerObject} from './geoapi.js';
import {integroNextProject, integroPrevProject, integroGetProjectLinked, integroGetProject, integroLinkProject} from './geoapi.js';


export function getToDesc(project_id) 
{
  console.log('getToDesc', project_id);    
  if (project_id) {   
   $.ajax({
    type : 'POST',
    url : "http://45.86.180.252/description",
    data:{ idProject: project_id },
    async:false,
    success : function(data){
      console.log(data);            
    },
    error : function(data){
      console.log(data);
    },
   });    
   window.open("http://45.86.180.252/description", '_blank');
  }
}

export function getPopupBar(object)
{
  var text = '';
  if(object != undefined && object != null) {      
    text = '<div class="content" id="content" data-id='+object.id+'><h3>'+object.name_full+'</h3><p>Проект</p><div class="container">';
    for(var r in object.meta)      
      text += '<div class="row border-bottom"><div class="col">'+r+'</div><div class="col">'+
                object.meta[r]+
               '</div></div>';
    text += '<div class="row">'+    
        '<div class="col"><a ref="#" class="btn btn-primary btn-sm desc-link">Подробнее</button></div>'+
        '</div><div class="row">'+
        '<div class="col"><a href="#" class="prev-link">Пред. проект</a></div>'+
        '<div class="col"><a href="#" class="next-link">След. проект</a></div>'+
        '</div>';
    text += '</div></div>';        
  }
  return text;  
}

export function getPopupBarCountry(object)
{
  //'<div><h2>Страна</h2><p>'+data.features[0].properties.name+'</p></div>'
  var text = '';
  if(object != undefined && object != null) {      
    text = '<div id="content" data-id='+object.id+'><h3>'+object.properties.name+'</h3><p>Страна</p><div class="container">';
    for(var r in object.properties)      
      text += '<div class="row border-bottom"><div class="col">'+r+'</div><div class="col">'+
                object.properties[r]+
               '</div></div>';    
    text += '</div></div>';        
  }
  return text;  
}
