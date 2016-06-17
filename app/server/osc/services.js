var db = rootRequire('./odbc');

function getOSC(req, res) {
	var id = req.params.id;
	db.osc.getOSC(id, function(result){
		res.json(result);
	});
}

function updateOSC(req, res) {
	var oscReq = req.body.osc;
	
	var osc = {
				  id: 281141,
			      dadosGerais: {
			    	  nomeFantasia: oscReq.nome, 
			    	  descricao: oscReq.cnpj
//			    	  , anoFundacao: 'test'
			      },
				  dirigentes: [
				      {
				    	  nome: 'test1',
				    	  cargo: 'test1'
				      },
				      {
				    	  nome: 'test2',
				    	  cargo: 'test2'
				      },
				      {
				    	  nome: 'test3',
				    	  cargo: 'test3'
				      }
				  ]
			  };
	
	db.osc.updateOSC(osc, function(err){
		if(err){
			console.log('Ocorreu um erro');
		}
		res.send(err);
	});
}

module.exports = {
	getOSC: getOSC,
	updateOSC: updateOSC
}
