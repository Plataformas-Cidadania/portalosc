INSERT INTO osc.tb_area_atuacao (
	id_osc, 
	cd_area_atuacao, 
	cd_subarea_atuacao, 
	ft_area_atuacao, 
	bo_oficial
)
VALUES (
	789809, 
	1, 
	1, 
	'MTE/RAIS', 
	false
);

INSERT INTO osc.tb_area_atuacao (
	id_osc, 
	cd_area_atuacao, 
	cd_subarea_atuacao, 
	ft_area_atuacao, 
	bo_oficial
)
VALUES (
	789809, 
	1, 
	2, 
	'Representante', 
	false
);

INSERT INTO osc.tb_area_atuacao (
	id_osc, 
	cd_area_atuacao, 
	cd_subarea_atuacao, 
	ft_area_atuacao, 
	bo_oficial
)
VALUES (
	789809, 
	1, 
	3, 
	'Representante', 
	false
);

INSERT INTO osc.tb_area_atuacao (
	id_osc, 
	cd_area_atuacao, 
	cd_subarea_atuacao, 
	ft_area_atuacao, 
	bo_oficial
)
VALUES (
	789809, 
	2, 
	null, 
	'Representante', 
	false
);

INSERT INTO osc.tb_area_atuacao_declarada (
	id_area_atuacao_declarada, 
	tx_nome_area_atuacao_declarada, 
	ft_nome_area_atuacao_declarada
)
VALUES (
	1,
	'Correção de erros enfadonhos', 
	'Representante'
);

INSERT INTO osc.tb_area_atuacao_outra (
	id_osc, 
	id_area_atuacao_declarada, 
	ft_area_atuacao_outra
)
VALUES (
	789809,
	1, 
	'Representante'
);
