INSERT INTO osc.tb_publico_beneficiado (
	id_publico_beneficiado, 
	tx_nome_publico_beneficiado, 
	ft_publico_beneficiado
)
VALUES (
	1, 
	'Crianças carentes', 
	'Representante'
);



INSERT INTO osc.tb_publico_beneficiado (
	id_publico_beneficiado, 
	tx_nome_publico_beneficiado, 
	ft_publico_beneficiado
)
VALUES (
	2, 
	'Jovens necessitados', 
	'Representante'
);



INSERT INTO osc.tb_publico_beneficiado_projeto (
	id_projeto, 
	id_publico_beneficiado, 
	ft_publico_beneficiado_projeto, 
	nr_estimativa_pessoas_atendidas, 
	bo_oficial
)
VALUES (
	2, 
	1, 
	'Representante', 
	150, 
	false
);



INSERT INTO osc.tb_publico_beneficiado_projeto (
	id_projeto, 
	id_publico_beneficiado, 
	ft_publico_beneficiado_projeto, 
	nr_estimativa_pessoas_atendidas, 
	bo_oficial
)
VALUES (
	3, 
	2, 
	'Representante', 
	100, 
	false
);