var db = rootRequire('./odbc');

//mock do json de busca de dados
var mockJSON = {
	"cabecalhoOsc": {
		"Logotipo da OSC": null,
		"Nome da OSC": "nome da OSC",
		"CNPJ": "1234569000100",
		"Natureza Jurídica": "Associação Privada",
		"Atividade Econômica": "Serviços de assistência social sem alojamento"
	},
	"dadosGerais": {
		"Nome Fantasia": "",
		"Endereço": "Endereco inteiro",
		"Responsável Legal": "",
		"Ano de Fundação": "",
		"E-mail": "",
		"Site": "",
		"Descrição da OSC": "",
		"Missão da OSC": "",
		"Visão da OSC": ""
	},
	"titulosCertificacoes": {
		"XPTO": "Possui",
		"ABCDE": "Não possui"
	},
	"relacoesDeTrabalho": [{
		"colaboradores": {
			"Total de colaboradores": 20,
			"Trabalhadores": 11,
			"Voluntários": 8,
			"Colaboradores portadores de deficiência": 1
		}
	},
		{
			"diretores": {
				"Diretor Geral": "Joaquim das Couves",
				"Diretor de Operações": "José das Neves"
			}
		}],
	"recursos": [{
		"itens": {
			"Federais": 1000,
			"Estaduais": 200,
			"Municipais": 500,
			"Privados": 300,
			"Proprios": 0,
			"Total": 2000
		}
	},
		{
			"links":{
				"Relatórios de Auditores Independentes": null,
				"Demonstrações Contábeis": null
			}
	}],
	"projetos": [{
		"Nome": "string",
		"Status": "string",
		"Data de Início": null,
		"Data de Fim": null,
		"Valor Total": 102643.21,
		"Fonte de Recursos": "string",
		"Link": "string",
		"Público beneficiado": "string",
		"Abrangência": "string",
		"Localização do Projeto": "",
		"Financiadores do Projeto": "string",
		"Descrição do Projeto": "string"
	}]
};

function getOSC(req, res) {
	var id = req.params.id;
	/*db.osc.getOSC(id, function(result){
		res.json(result);
	});*/
	console.log(mockJSON);
	res.json(mockJSON);
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
