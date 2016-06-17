var db = rootRequire('./odbc');

//mock do json de busca de dados
var mockJSON = {
	"dadosGerais": {
		"logo": null,
		"cnpj": "1234569000100",
		"razoSocial": "ASSOCIACAO TESTE",
		"nomeFantasia": "",
		"naturezaJuridica": "Associação Privada",
		"atividadeEconomica": "Serviços de assistência social sem alojamento",
		"anoFundacao": "1940",
		"site": "",
		"descricao": ""
	},
	"endereco": {
		"logradouro": "AV. GENERAL JUSTO , 275",
		"municipio": "Rio de Janeiro",
		"uf": "RJ"
	},
	"contato": {
		"email": "test@test.org.br"
	},
	"vinculos": {
		"clt": 12,
		"voluntarios": 0,
		"deficientes": null
	},
	"dirigentes": [
		{
			"cargo": "Diretor Geral",
			"nome": "TEST 1"
		},
		{
			"cargo": "Diretor",
			"nome": "TEST 2"
		}
	],
	"recursos": {
		"federal": null,
		"estadual": null,
		"municipal": null,
		"privado": null,
		"proprio": null,
		"total": null
	},
	"conselhos": [
		{
			"nomeConselho": "Conselho Nacional do Meio Ambiente"
		}
	],
	"projetos": [
			{
				"titulo": "string",
				"status": "string",
				"dataInicio": null,
				"dataFinal": null,
				"valorTotal": 102643.21,
				"fonteRecursos": "string",
				"link": "string",
				"publicoBeneficiado": "string",
				"abrangencia": "string",
				"localizacao": {
					"tipoLocalizacao": "string",
					"nomeLocalizacao": "string"
				},
				"financiadores": "string",
				"descricao": "string"
			}
		],
	"convenios": [
		{
			"status": "Prestação de Contas em Análise",
			"dataInicio": "2011-12-26T00: 00: 00.000Z",
			"dataFinal": "2013-12-26T00: 00: 00.000Z",
			"valorTotal": 102643.43,
			"orgaoConcedente": "SECRETARIA DE DIREITOS HUMANOS",
			"publicoBeneficiado": "",
			"abrangencia": ""
		},
		{
			"status": "Prestação  de Contas enviada para Análise",
			"dataInicio": "2011-12-26T00: 00: 00.000Z",
			"dataFinal": "2013-12-26T00: 00: 00.000Z",
			"valorTotal": 434530.96,
			"orgaoConcedente": "SECRETARIA DE DIREITOS",
			"publicoBeneficiado": "",
			"abrangencia": ""
		}
	],
	"certificados": {
		"dataCnea": null,
		"dataInicioCebasMec": null,
		"dataFinalCebasMec": null,
		"dataInicioCebasSaude": null,
		"dataFinalCebasSaude": null,
		"dataOscip": null,
		"dataUpf": "2003-11-06T00: 00: 00.000Z",
		"dataInicioCebasMdf": null,
		"dataFinalCebasMdf": null
	}
};

function getOSC(req, res) {
	var id = req.params.id;
	/*db.osc.getOSC(id, function(result){
		res.json(result);
	});*/
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
