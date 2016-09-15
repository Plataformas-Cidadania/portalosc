var Header = React.createClass({
  render: function() {
    return (
      <div>
        <div class="barra-governo">&nbsp;</div>
        <h2>{this.props.title}</h2>
      </div>
    );
  }
});


var Dropdown = React.createClass({
  getInitialState:function(){
      return {selectValue:this.props.list[0]};
  },
  handleChange: function(e){
    this.setState({selectValue: e.target.value});
  },
  renderListItems: function () {
    var items = [];

    for(var i=0; i<this.props.list.length; i++){
      var val = this.props.list[i];
      items.push(<option value={val}>{val}</option>);
    }

    return items;
  },
    render: function() {
        return (
          <div>
           <select>
              {this.renderListItems()}
            </select>
          </div>
        );
    }
});

var title = "componente teste";
var lista = ["XML", "JSON", "CSV"];

ReactDOM.render(<Dropdown list={lista}/>, document.getElementById("container"));
ReactDOM.render(<Header title={title}/>, document.getElementById("header"));
/*

<div class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand brand-master-style" contenteditable="true">
        <img src="simbolo.png" class="brand-style">
        <span class="brand-text-style">Mapa das Organizações da Sociedade Civil</span></a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-ex-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active">
            <a href="#">Home</a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">O Mapa<i class="fa fa-caret-down"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="#">Sobre </a>
              </li>
              <li>
                <a href="#">Versão</a>
              </li>
              <li>
                <a href="#">Metodologia</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="#">FAQ</a>
              </li>
              <li>
                <a href="#">Glossário</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="#">Equipe</a>
              </li>
              <li>
                <a href="#">Apoio</a>
              </li>
              <li>
                <a href="#">Links</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">Mapa</a>
          </li>
          <li>
            <a href="#">Dados</a>
          </li>
          <li>
            <a href="#">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="carousel slide" id="fullcarousel-example" data-interval="5000" data-ride="carousel">
    <div class="carousel-inner">
      <div class="item">
        <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png">
        <div class="carousel-caption">
          <h2>Title</h2>
          <p>Description</p>
        </div>
      </div>
      <div class="item">
        <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png">
        <div class="carousel-caption">
          <h2>Title</h2>
          <p>Description</p>
        </div>
      </div>
    </div>
    <a class="left carousel-control" href="#fullcarousel-example" data-slide="prev"><i class="icon-prev fa fa-angle-left"></i></a>
    <a class="right carousel-control" href="#fullcarousel-example" data-slide="next"><i class="icon-next fa fa-angle-right"></i></a>
  </div>
*/
