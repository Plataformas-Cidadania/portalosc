var controller = angular.module('oscApp', []);

controller.controller('OscCtrl', ['$http', '$location', function($http, $location) {
	var self = this;

	self.carregarDadosGerais = function(){
		var idOsc = $location.path().split('/')[1];
		var url = 'http://localhost:8080/organization/id/' + idOsc;

		$http.get(url).then(function(response) {
			if(response.data.msg == undefined){
				self.osc = response.data;
	    	self.msg = '';
        console.log(self.osc);
			}else{
				self.msg = response.data.msg;
			}
		});
	};

	self.carregarProjetos = function(){
		var idOsc = $location.path().split('/')[1];
		var url = 'http://localhost:8080/organization/projects/id/' + idOsc;

		$http.get(url).then(function(response) {
			if(response.data.msg == undefined){
				self.projects = response.data;
	    		self.msg = '';
			}else{
				self.msg = response.data.msg;
			}
		});
	};
}]);
