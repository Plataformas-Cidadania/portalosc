//var db = rootRequire('./odbc');

//mock do json de busca de dados
var mockJSON = {
	"cabecalhoOsc": [{
		"nome": "logotipoOsc",
		"rotulo": "Logotipo da OSC",
		"valor": null
	}, {
		"nome": "nomeOsc",
		"rotulo": "Nome da OSC",
		"valor": "Nome da OSC (Nome Receita/RAIS)"
	}, {
		"nome": "cnpj",
		"rotulo": "CNPJ",
		"valor": "1234569000100"
	}, {
		"nome": "naturezaJuridica",
		"rotulo": "Natureza Jurídica",
		"valor": "Associação Privada"
	}, {
		"nome": "atividadeEconomica",
		"rotulo": "Atividade Econômica",
		"valor": "Serviços de assistência social sem alojamento"
	}],
	"dadosGerais": [{
		"nome": "nomeFantasia",
		"rotulo": "Nome Fantasia",
		"valor": "Nome fantasia exemplo"
	}, {
		"nome": "endereco",
		"rotulo": "Endereço",
		"valor": "Endereço inteiro"
	}, {
		"nome": "responsavelLegal",
		"rotulo": "Responsável Legal",
		"valor": "Responsável Legal exemplo"
	}, {
		"nome": "anoFundacao",
		"rotulo": "Ano de Fundação",
		"valor": "Ano de Fundação exemplo"
	}, {
		"nome": "email",
		"rotulo": "E-mail",
		"valor": "site@exemplo.com"
	}, {
		"nome": "site",
		"rotulo": "Site",
		"valor": "site.com"
	}, {
		"nome": "descricaoOsc",
		"rotulo": "Descrição da OSC",
		"valor": "Descrição da OSC exemplo"
	}, {
		"nome": "missaoOsc",
		"rotulo": "Missão da OSC",
		"valor": "Missão da OSC exemplo"
	}, {
		"nome": "visaoOsc",
		"rotulo": "Visão da OSC",
		"valor": "Visão da OSC exemplo"
	}],
	"titulosCertificacoes": [{
		"nome": "XPTO",
		"rotulo": "XPTO",
		"valor": "Não possui"
	}, {
		"nome": "ABCDE",
		"rotulo": "ABCDE",
		"valor": "Possui"
	}],
	"relacoesDeTrabalho": {
		"colaboradores": [{
			"rotulo": "Total de colaboradores",
			"valor": 20
		}, {
			"rotulo": "Trabalhadores",
			"valor": 11
		}, {
			"rotulo": "Voluntários",
			"valor": 8
		}, {
			"rotulo": "Colaboradores portadores de deficiência",
			"valor": 1
		}],
		"diretores": [{
			"rotulo": "Diretor Geral",
			"valor": "Joaquim das Couves"
		}, {
			"rotulo": "Diretor de Operações",
			"valor": "José das Neves"
		}]
	},
	"recursos": {
		"itens": [{
			"rotulo": "Federais",
			"valor": 1000
		}, {
			"rotulo": "Estaduais",
			"valor": 200
		}, {
			"rotulo": "Municipais",
			"valor": 500
		}, {
			"rotulo": "Privados",
			"valor": 300
		}, {
			"rotulo": "Proprios",
			"valor": 0
		}, {
			"rotulo": "Total",
			"valor": 2000
		}],
		"links": [{
			"rotulo": "Relatórios de Auditores Independentes",
			"valor": "#"
		}, {
			"rotulo": "Demonstrações Contábeis",
			"valor": "#"
		}]
	},
	"projetos": [
		[{
			"rotulo": "Nome",
			"valor": "Projeto ABC"
		}, {
			"rotulo": "Status",
			"valor": "string"
		}, {
			"rotulo": "Data de Início",
			"valor": "05/05/16"
		}, {
			"rotulo": "Data de Fim",
			"valor": "05/05/19"
		}, {
			"rotulo": "Valor Total",
			"valor": 102643.21
		}, {
			"rotulo": "Fonte de Recursos",
			"valor": "string"
		}, {
			"rotulo": "Link",
			"valor": "string"
		}, {
			"rotulo": "Público beneficiado",
			"valor": "string"
		}, {
			"rotulo": "Abrangência",
			"valor": "string"
		}, {
			"rotulo": "Localização do Projeto",
			"valor": "string"
		}, {
			"rotulo": "Financiadores do Projeto",
			"valor": "string"
		}, {
			"rotulo": "Descrição do Projeto",
			"valor": "string"
		}],
		[{
			"rotulo": "Nome",
			"valor": "Projeto XPTO"
		}, {
			"rotulo": "Status",
			"valor": "string"
		}, {
			"rotulo": "Data de Início",
			"valor": null
		}, {
			"rotulo": "Data de Fim",
			"valor": null
		}, {
			"rotulo": "Valor Total",
			"valor": 232548.59
		}, {
			"rotulo": "Fonte de Recursos",
			"valor": "string"
		}, {
			"rotulo": "Link",
			"valor": "string"
		}, {
			"rotulo": "Público beneficiado",
			"valor": "string"
		}, {
			"rotulo": "Abrangência",
			"valor": "string"
		}, {
			"rotulo": "Localização do Projeto",
			"valor": "string"
		}, {
			"rotulo": "Financiadores do Projeto",
			"valor": "string"
		}, {
			"rotulo": "Descrição do Projeto",
			"valor": "string"
		}]
	]
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
