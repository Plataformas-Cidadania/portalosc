INSERT INTO osc.tb_conferencia_declarada (
	tx_nome_conferencia_declarada, 
	ft_conferencia_declarada
)
VALUES (
	'Conf�rencia Nacional das Organiza��es de Aux�lio ao Sr. Jo�o Am�rico', 
	'Representante'
);



INSERT INTO osc.tb_participacao_social_conferencia_outra (
	id_conferencia_declarada, 
	ft_conferencia_declarada, 
	id_osc, 
	dt_ano_realizacao, 
	ft_ano_realizacao, 
	cd_forma_participacao_conferencia, 
	ft_forma_participacao_conferencia
)
VALUES (
	1, 
	'Representante', 
	987654, 
	'2016-01-01', 
	'Representante', 
	1, 
	'Representante'
);
