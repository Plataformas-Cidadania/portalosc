document.addEventListener("DOMContentLoaded", function(event) {

  var request = new XMLHttpRequest();
  var oscId = getUrlParameter('id');
  request.open('GET', '/osc/' + oscId, true);

  request.onload = function() {
    if (request.status >= 200 && request.status < 400) {
      console.log('Success! ');
      var data = JSON.parse(request.responseText);
      fillOscData(data);
    } else {
      // We reached our target server, but it returned an error
    }
  };
  request.onerror = function() {
    // There was a connection error of some sort
  };
  request.send();
});

function fillOscData(data) {
  var container = document.getElementById('dados_gerais');
  var headerSection = document.createElement('h2');
  var headerSectionContent = document.createTextNode("Dados Gerais");
  headerSection.appendChild(headerSectionContent);

  var divContainer = document.createElement('div');
  divContainer.setAttribute('class', 'col-md-5');

  for (var key of Object.keys(data)) {
    var div = document.createElement('div');
    var label = document.createElement('label');
    var span = document.createElement('span');

    label.appendChild(document.createTextNode(key + ':'));
    span.appendChild(document.createTextNode(data[key]));

    div.appendChild(label);
    div.appendChild(span);

    divContainer.appendChild(div);
    console.log(key + ':' + data[key]);
  }
  container.appendChild(divContainer);
}

function getUrlParameter(sParam) {
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
