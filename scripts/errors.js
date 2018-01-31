/**
 * A generic error logging script. This sends all details of the error to the server to get logged.
 *
 * @param msg
 * @param url
 * @param linenumber
 * @returns
 */
var writeError = function(msg, url, linenumber){
    var params = "url=" + url + "&msg=" + msg + "&line=" + linenumber;
    sendData(g.root_url + "/modules/js_error_logs/code/logs.php", encodeURI(params));
    return false;
};

window.onerror = function(msg, url, line){
    return writeError(msg, url, line);
};

function sendData(url, params) {
    if (typeof params == 'undefined') {
        params = '';
    }
    var req = createXMLHTTPObject();
    if (!req) {
        return;
    }

    req.open("POST", url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    //Just for illustration purposes, display the errors on the page, in addition to logging them
    req.onreadystatechange = function() {
        if(req.readyState == 4 && req.status == 200) {
            var newError = document.createElement("div");
            newError.className = "errorDiv";
            newError.innerHTML = req.responseText;
            document.body.appendChild(newError);
        }
    }

    req.send(params);
    return req.responseText; // error in IE 8...
}

function createXMLHTTPObject() {
    var xmlhttp, XMLHttpFactories = [
        function() {
                return new XMLHttpRequest();
            }, function() {
                return new ActiveXObject('Msxml2.XMLHTTP');
            }, function() {
                return new ActiveXObject('Msxml3.XMLHTTP');
            }, function() {
                return new ActiveXObject('Microsoft.XMLHTTP');
            }
        ];
    for (var i = 0; i < XMLHttpFactories.length; i++) {
        try {
            xmlhttp = XMLHttpFactories[i]();
            // Use memoization to cache the factory
            createXMLHTTPObject = XMLHttpFactories[i];
            return xmlhttp;
        } catch (e) {}
    }
}
