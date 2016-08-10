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
  var cabecalhoE = document.createElement('cabecalho-osc');
  container.appendChild(cabecalhoE);
  cabecalhoE.populate(data);
}

function fillDadosGerais(data) {
  var container = document.getElementById('dados_gerais');
  var dadosGeraisE = document.createElement('dados-gerais-osc');
  container.appendChild(dadosGeraisE);
  dadosGeraisE.populate(data);
}

function fillAreasDeAtuacao(data) {
  var container = document.getElementById('areas_de_atuacao');
  var areasDeAtuacaoE = document.createElement('areas-de-atuacao-osc');
  container.appendChild(areasDeAtuacaoE);
  areasDeAtuacaoE.populate(data);
}

function fillDescricao(data) {
  var container = document.getElementById('descricao');
  var descricaoE = document.createElement('descricao-osc');
  container.appendChild(descricaoE);
  descricaoE.populate(data);
}

function fillTitulosCertificacoes(data) {
  var container = document.getElementById('menu2');
  var titulosCertificacoesE = document.createElement('titulos-certificacoes-osc');
  container.appendChild(titulosCertificacoesE);
  titulosCertificacoesE.populate(data);
}

function fillRelacoesDeTrabalho(data) {
  var container = document.getElementById('menu3');
  var relacoesTrabalhoE = document.createElement('relacoes-trabalho-osc');
  container.appendChild(relacoesTrabalhoE);
  relacoesTrabalhoE.populate(data);
}

function fillEspacosDeParticipacao(data) {
  var container = document.getElementById('espacos');
  var espacosDeParticipacao = document.createElement('espacos-de-participacao-osc');
  container.appendChild(espacosDeParticipacao);
  espacosDeParticipacao.populate(data);
}

function fillRecursos(data) {
  var container = document.getElementById('menu4');
  var recursosE = document.createElement('recursos-osc');
  container.appendChild(recursosE);
  recursosE.populate(data);
}

function fillProjetos(data) {
  var container = document.getElementById('menu5');
  var projetosE = document.createElement('projetos-osc');
  container.appendChild(projetosE);
  projetosE.populate(data);
}

function fillOscData(data) {
  fillCabecalho(data.cabecalhoOsc);
  fillDadosGerais(data.dadosGerais);
  fillAreasDeAtuacao(data.areasDeAtuacao);
  fillDescricao(data.descricao);
  fillTitulosCertificacoes(data.titulosCertificacoes);
  fillRelacoesDeTrabalho(data.relacoesDeTrabalho);
  fillEspacosDeParticipacao(data.espacosDeParticipacao);
  fillRecursos(data.recursos);
  fillProjetos(data.projetos);
}
