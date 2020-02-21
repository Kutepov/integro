(function (w) {

    var _api = {
        apiKey: null,
        init: null,
        ready: null,
        initialConfig: null,
        getExtent: null,
        src: null,
        receiveMessage: null,
        frame: null,
    };


    //
    // _api.initialConfig = {
    //     service: null,
    //     layersConfig: null, // { defaultLayers: [], requiredLayers: [], mainLayers: [] }
    //     homeCenter: null,
    //     homeZoom: null,
    //     workSetFitDisabled: false,
    //     workSetId: null,
    //     interfaceConfig: null, // { isStatusBarHidden: null, isMainToolbarHidden: null, hiddenTools: null }
    // }

    // <script ... data-api-key="API_KEY"></script>
    var scripts = document.getElementsByTagName("script");
    var isGeoportalApi = function isGeoportalApi(scriptElem){
        return (
            scriptElem.getAttribute("src") != null
            && scriptElem.getAttribute("src").length > 0
            && scriptElem.getAttribute("src").indexOf("api.js") >= 0
            && scriptElem.dataset != null
            && scriptElem.dataset.apiKey != null
        )
    };
    var _elem;
    for (var i = 0; i < scripts.length; ++i) {
        if (isGeoportalApi(scripts[i])){
            _elem = scripts[i];
        }
    }

    _api.apiKey = _elem && _elem.dataset && _elem.dataset.apiKey || null;
    _api.src = _elem && _elem.src;
    _api.src = _api.src.replace(/\/[^\/]+$/, "/");

    _api.init = function (el, config) {
        var queryParamsObject = {config: JSON.stringify(config)};
        if (this.apiKey) queryParamsObject.apiKey = this.apiKey;

        var queryParams = this.jsonToQueryString(queryParamsObject);

        var iframe = _api.frame = document.createElement("iframe");
        iframe.src = _api.src + "index-api.html" + queryParams;
        var target = document.getElementById(el);
        iframe.frameBorder = "0px";
        iframe.sandbox = "allow-same-origin allow-scripts";
        iframe.width = "100%";
        iframe.height = "100%";
        if (target) {
            target.appendChild(iframe);
        }
    };

    _api.jsonToQueryString = function (json) {
        return "?" +
            Object.keys(json).map(function (key) {
                return encodeURIComponent(key) + "=" +
                    encodeURIComponent(json[key]);
            }).join("&");
    };

    _api.isObject = function (val) {
        if (val != null) {
            if (typeof val === "object" && !Array.isArray(val)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    };

    _api.getExtent = function (proj, cb) {
        _api.getExtentCB = cb;
        _api.sentPost("getExtent", proj, "getExtentCB");
    };
    _api.getExtentCB = null;
    _api.updateMapSize = function () {
        _api.sentPost("updateMapSize");
    };

    _api.activateLayer = function (service, layerCodeName) {
        _api.sentPost("activateLayer", [service, layerCodeName]);
    };

    _api.deactivateLayer = function (service, layerCodeName) {
        _api.sentPost("deactivateLayer", [service, layerCodeName]);
    };

    _api.unselectAllLayers = function () {
        _api.sentPost("unselectAllLayers");
    };

    _api.showObject = function (service, layerCodeName, objectId) {
        _api.sentPost("showObject", [objectId, service, layerCodeName]);
    };

    _api.showGeometry = function (GeoJSON, styleCodeName, editMode) {
        _api.sentPost("showGeometry", [GeoJSON, editMode || false, styleCodeName || null]);
    };

    _api.showExternalObject = function (JSONObject, styleCodeName) {
        var obj = null;
        try {
            obj = JSON.parse(JSONObject);
        } catch (e) {
            return;
        }
        if (obj) {
            _api.sentPost("showExternalObject", [JSON.stringify(obj.fields), JSON.stringify(obj.geoJSON), styleCodeName || null]);
        }
    };

    _api.clearGeometry = function () {
        _api.sentPost("clearGeometry");
    };

    _api.getCurrentObjectCB = null;
    _api.currentObject = function (cb) {
        _api.getCurrentObjectCB = cb;
        _api.sentPost("getCurrentObject", null, "getCurrentObjectCB");
    };


    w.GeoportalApi = {
        instance: null,
        init: _api.init.bind(_api),
        ready: null,
        getExtent: _api.getExtent.bind(_api),
        updateMapSize: _api.updateMapSize,
        activateLayer: _api.activateLayer,
        deactivateLayer: _api.deactivateLayer,
        unselectAllLayers: _api.unselectAllLayers,
        showObject: _api.showObject,
        showGeometry: _api.showGeometry,
        showExternalObject: _api.showExternalObject,
        currentObject: _api.currentObject,
        clearGeometry: _api.clearGeometry,
        onMapClick: null,
        onIdentifyObject: null,
        onClearObject: null
    };

    // _api.ready = w.GeoportalApi.ready;
    // _api.onIdentifyObject = w.GeoportalApi.onIdentifyObject;
    // _api.onClearObject = w.GeoportalApi.onClearObject;

    _api.receiveMessage = function (event) {
        if (typeof event.data !== "string") {
            return;
        }
        var data = event.data.split(":::"),
            method = data[0] || null,
            params = data[1] && JSON.parse(data[1]) || null;

        if (method === "ready" && typeof w.GeoportalApi.ready === "function") {
            w.GeoportalApi.ready();
        }

        if (method === "onMapClick" && typeof w.GeoportalApi.onMapClick === "function") {
            w.GeoportalApi.onMapClick(params.coordinate, params.srCode);
        }

        if (method === "onIdentifyObject" && typeof w.GeoportalApi.onIdentifyObject === "function") {
            w.GeoportalApi.onIdentifyObject(params);
        }
        if (method === "onClearObject" && typeof w.GeoportalApi.onClearObject === "function") {
            w.GeoportalApi.onClearObject(params);
        }

        if (method && typeof _api[method] === "function") {
            _api[method].call(this, params);
        }
    };

    _api.sentPost = function (method, params, cb) {
        _api.frame.contentWindow.postMessage(method + ":::" + JSON.stringify(params) + ":::" + cb, "*");
    };

    window.addEventListener("message", _api.receiveMessage, false);

})(window);

GeoportalApi = window.GeoportalApi;