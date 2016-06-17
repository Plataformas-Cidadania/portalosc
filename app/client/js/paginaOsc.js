document.addEventListener("DOMContentLoaded", function(event) {
  var type = 'GET';
  var url = '/osc/';
  var oscId = Util.getUrlParameter('id');

  Util.ajax(type, url, oscId, fillOscData).then(function(data) {
    fillOscData(data);
  }).catch(function() {
    // An error occurred
  });

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
