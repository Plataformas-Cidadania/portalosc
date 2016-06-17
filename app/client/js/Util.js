function Util () {}

Util.ajax = function(type, url, data, callback) {
  return new Promise(function(resolve, reject) {
    var request = new XMLHttpRequest();
    request.onload = function() {
      var data = JSON.parse(this.responseText);
      resolve(data);
    };
    request.onerror = reject;
    request.open(type, url + data, true);
    request.send();
  });
};

Util.getUrlParameter = function(sParam) {
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : sParameterName[1];
    }
  }
};
