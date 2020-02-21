export const API_KEY = 'my5cca9rm8bp56wxxh';

//$.ajaxSetup({  headers:{ 'X-API-Key': API_KEY }});
export const API_HEADER = {'X-API-Key':API_KEY};
export const API_OPTIONS = {headers:API_HEADER};

export const APIURL = 'http://10.246.127.177:8080/rest/api/v1';
//const APIURL = 'http://10.246.127.173:8080/rest/api/v1';
//const APIURL = 'http://10.246.127.173/api';

export const WMSURL = 'http://10.246.127.177:8080/gis/gwc/service/wms';
export const OWSURL = 'http://10.246.127.177:8080/gis/ows';

export const INTEGROURL = 'http://45.86.180.252/api';

export const SERVICE = 'integro';
export const PROJECTS_LAYER = 'world_projects';
export const COUNTRIES_LAYER = 'world_boundary';
export const POINTS_LAYER = 'lyr_intgr_pnt';
export const POLYGONS_LAYER = 'lyr_intgr_pol';
//lyr_intgr_line
