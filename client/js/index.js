document.addEventListener("DOMContentLoaded", function(event) {
  var goButton = document.getElementsByClassName('btn-primary')[0];
  goButton.onclick = function(){
    var oscId = document.getElementById('oscIdElement').value;
    window.location.replace('html/paginaOsc.html?id=' + oscId);
  }
});
