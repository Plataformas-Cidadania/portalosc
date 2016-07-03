document.addEventListener('DOMContentLoaded', function(event) {
  const type = 'GET';
  const url = '/osc/';
  var oscId = Util.getUrlParameter('id');

  Util.ajax(type, url, oscId, fillOscData).then(function(data) {
    fillOscData(data);
  }).catch(function () {
    // An error occurred
  });
});

function createDataElements(data, divContainer){
  for (var i in data) {
    var project = data[i];
    console.log(project);
  }
}

function createProjectsElements(data){
  var projects = [];
  for (var i in data) {
    var divContainer = document.createElement('div');
    var div = document.createElement('div');
    var title = document.createElement('h3');
    var titleLink = document.createElement('a');

    divContainer.setAttribute('class', 'panel panel-default');
    div.setAttribute('class', 'panel-heading');
    title.setAttribute('class', 'panel-title');
    titleLink.setAttribute('class', 'collapsed');
    titleLink.setAttribute('data-toggle', 'collapse');
    var id = parseInt(i) + 1;
    titleLink.setAttribute('href', `#collapse${id}`);
    titleLink.setAttribute('aria-expanded', 'false');

    titleLink.appendChild(document.createTextNode(data[i].Nome));
    title.appendChild(titleLink);
    div.appendChild(title);
    divContainer.appendChild(div);

    //divContainer = createDataElements(data, divContainer);

    projects.push(divContainer);
  }
  return projects;
}

function createLabelDataElements(object, divContainer){
  for (var key of Object.keys(object)) {
    var div = document.createElement('div');
    var label = document.createElement('label');
    var span = document.createElement('span');

    label.appendChild(document.createTextNode(key + ':'));
    span.appendChild(document.createTextNode(object[key]));

    div.appendChild(label);
    div.appendChild(span);

    divContainer.appendChild(div);
  }
  return divContainer;
}

function createLinks(object, divContainer){
  for (var key of Object.keys(object)) {
    var div = document.createElement('div');
    var a = document.createElement('a');

    a.appendChild(document.createTextNode(key));

    if (object[key]) {
      a.setAttribute('href', object[key]);
    } else {
      a.setAttribute('href', '#');
    }

    div.appendChild(a);

    divContainer.appendChild(div);
  }
  return divContainer;
}

function fillCabecalho(data) {

  var container = document.getElementById('highlights');
  var div = document.createElement('div');
  div.setAttribute('class', 'col-md-9');
  var key = null;

  for (key of Object.keys(data)) {
    if (key === 'Logotipo da OSC'){
      //do something
    }
    else if (key === 'Nome da OSC'){
      var nomeOsc = document.createElement('h2');
      nomeOsc.appendChild(document.createTextNode(data[key]));
      div.appendChild(nomeOsc);
    } else {
      var element = document.createElement('h3');
      element.appendChild(document.createTextNode(data[key]));
      div.appendChild(element);
    }
  }
  container.appendChild(div);
}

function fillDadosGerais(data) {
  var container = document.getElementById('dados_gerais');
  var dadosGeraisE = document.createElement('dados-gerais');
  dadosGeraisE.setAttribute('s_obj', JSON.stringify(data));
  container.appendChild(dadosGeraisE);
  dadosGeraisE.populateColumns(data);
}

function fillTitulosCertificacoes(data) {
  var container = document.getElementById('menu2');
  var divContainer = document.createElement('div');

  divContainer.setAttribute('class', 'col-md-8');

  divContainer = createLabelDataElements(data, divContainer);

  container.appendChild(divContainer);
}

function fillRelacoesDeTrabalho(data) {
  var container = document.getElementById('menu3');
  var colaboradores = data[0].colaboradores;
  var diretores = data[1].diretores;

  var divContainer = document.createElement('div');
  divContainer.setAttribute('class', 'col-md-5');

  var headerSection = document.createElement('h3');
  var headerSectionContent = document.createTextNode("Colaboradores");
  headerSection.appendChild(headerSectionContent);
  divContainer.appendChild(headerSection);

  divContainer = createLabelDataElements(colaboradores, divContainer);
  container.appendChild(divContainer);

  divContainer = document.createElement('div');
  divContainer.setAttribute('class', 'col-md-7');

  var headerSection = document.createElement('h3');
  var headerSectionContent = document.createTextNode("Diretores");
  headerSection.appendChild(headerSectionContent);
  divContainer.appendChild(headerSection);

  divContainer = createLabelDataElements(diretores, divContainer);
  container.appendChild(divContainer);
}

function fillRecursos(data) {
  var container = document.getElementById('menu4');
  var divContainer = document.createElement('div');
  var itens = data[0].itens;
  var links = data[1].links;

  divContainer.setAttribute('class', 'col-md-5');

  divContainer = createLabelDataElements(itens, divContainer);

  container.appendChild(divContainer);

  divContainer = document.createElement('div');
  divContainer.setAttribute('class', 'col-md-7');

  divContainer = createLinks(links, divContainer);
  container.appendChild(divContainer);
}

function fillProjetos(data) {
  var container = document.getElementById('menu5');

  var projects = createProjectsElements(data);
  container.appendChild(projects[0]);
}

function fillOscData(data) {
  fillCabecalho(data.cabecalhoOsc);
  fillDadosGerais(data.dadosGerais);
  fillTitulosCertificacoes(data.titulosCertificacoes);
  fillRelacoesDeTrabalho(data.relacoesDeTrabalho);
  fillRecursos(data.recursos);
  fillProjetos(data.projetos);
}
