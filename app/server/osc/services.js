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
		"nome": "sigla",
		"rotulo": "Sigla da OSC",
		"valor": "XPAD"
	}, {
		"nome": "endereco",
		"rotulo": "Endereço do Imóvel",
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
		"nome": "telefone",
		"rotulo": "Telefone",
		"valor": "22499587"
	}, {
		"nome": "resumo",
		"rotulo": "Resumo da OSC",
		"valor": "Resumo da OSC exemplo"
	}, {
		"nome": "situacao",
		"rotulo": "Situação do Imóvel",
		"valor": "Regular"
	}, {
		"nome": "link",
		"rotulo": "Link do Estatuto",
		"valor": "link"
	}],
	"areasDeAtuacao": [{
		"nome": "area",
		"rotulo": "FASFIL",
		"valor": "Micro-área"
	},
	{
		"nome": "autodeclaradas",
		"rotulo": "Áreas autodeclaradas",
		"valor": [
			{
				"nome": "autodeclarada",
				"rotulo": "Área autodeclarada",
				"valor": "ABC"
			},
			{
				"nome": "autodeclarada",
				"rotulo": "Área autodeclarada",
				"valor": "DEFG"
			}
		]
	}],
	"descricao": [{
		"nome": "como",
		"rotulo": "Como surgiu a OSC",
		"valor": "xxxxxxxxxxxx"
	},{
		"nome": "missao",
		"rotulo": "Missão da OSC",
		"valor": "xxxxxxxxxxxx"
	}, {
		"nome": "visao",
		"rotulo": "Visão da OSC",
		"valor": "xxxxxxxxxxxx"
	}, {
		"nome": "finalidade",
		"rotulo": "Finalidades Estatutárias da OSC",
		"valor": "xxxxxxxxxxxx"
	}],
	"titulosCertificacoes": [{
		"nome": "XPTO",
		"rotulo": "XPTO",
		"valor": "Não possui",
		"emissao": "(xxxxxxx)"
	}, {
		"nome": "ABCDE",
		"rotulo": "ABCDE",
		"valor": "Possui",
		"emissao": "(xxxxxxx)"
	}],
	"relacoesDeTrabalho": {
		"colaboradores": {
			"nome": "colaboradores",
			"rotulo": "Colaboradores",
			"valor": [{
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
			}]
		},
		"diretores": {
			"nome": "diretores",
			"rotulo": "Quadro de Dirigentes",
			"valor": [{
				"rotulo": "Diretor Geral",
				"valor": "Joaquim das Couves"
			}, {
				"rotulo": "Diretor de Operações",
				"valor": "José das Neves"
			}]
		}
	},
	"espacosDeParticipacao": [{
			"nome": "conselhos",
			"rotulo": "Conselhos",
			"cabecalhos": ["Conselho", "Número de Assentos","Periodicidade"],
			"valor": [
				{
					"conselho": {
						"rotulo": "Conselho",
						"valor": "Conselho XPTO"
					},
					"numeroDeAssentos": {
						"rotulo": "Número de Assentos",
						"valor": "10"
					},
					"periodicidade": {
						"rotulo": "Periodicidade",
						"valor": "Mensal"
					}
				},
				{
					"conselho": {
						"rotulo": "Conselho",
						"valor": "Conselho ABD"
					},
					"numeroDeAssentos": {
						"rotulo": "Número de Assentos",
						"valor": "12"
					},
					"periodicidade": {
						"rotulo": "Periodicidade",
						"valor": "Anual"
					}
				}
			]

		},
		{
			"nome": "conferencias",
			"rotulo": "Conferências",
			"cabecalhos": ["Conferência", "Data de Início da Conferência","Data de Fim da Conferência"],
			"valor": [
				{
					"conferencia": {
						"rotulo": "Conferência",
						"valor": "Conferência XPTO"
					},
					"dataDeInicio": {
						"rotulo": "Data de Início da Conferência",
						"valor": "10/10/2016"
					},
					"dataDeFim": {
						"rotulo": "Data de Fim da Conferência",
						"valor": "16/10/2016"
					}
				},
				{
					"conferencia": {
						"rotulo": "Conferência",
						"valor": "Conferência ABD"
					},
					"dataDeInicio": {
						"rotulo": "Data de Início da Conferência",
						"valor": "18/10/2016"
					},
					"dataDeFim": {
						"rotulo": "Data de Fim da Conferência",
						"valor": "30/10/2016"
					}
				}
			]
		},
		{
			"nome": "outros",
			"rotulo": "Outros",
			"cabecalhos": ["Nome", "Tipo","Data de Ingresso"],
			"valor": [
				{
					"nome": {
						"rotulo": "Nome",
						"valor": "Moradores de Santa Teresa"
					},
					"tipo": {
						"rotulo": "Tipo",
						"valor": "Tipo desconhecido"
					},
					"dataDeIngresso": {
						"rotulo": "Data de Ingresso",
						"valor": "16/10/2016"
					}
				},
				{
					"nome": {
						"rotulo": "Nome",
						"valor": "Moradores de Santa Luzia"
					},
					"tipo": {
						"rotulo": "Tipo",
						"valor": "Tipo desconhecido"
					},
					"dataDeIngresso": {
						"rotulo": "Data de Ingresso",
						"valor": "17/10/2016"
					}
				}
			]
		}
	],
	"recursos": {
		"recursos": [{
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
		}],
		"conselhoContabil": [{
			"rotulo": "Abc",
			"valor": "Abc"
		},
		{
			"rotulo": "Efg",
			"valor": "Efg"
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
