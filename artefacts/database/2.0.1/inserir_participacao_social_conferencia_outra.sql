DROP FUNCTION IF EXISTS portal.inserir_participacao_social_conferencia_outra(id integer, nomeconferenciadeclarada text, ftconferenciadeclarada text, ftconferenciadeclaradaoutra text, dtanorealizacao date, ftanorealizacao text, cdformaparticipacaoconferencia integer, ftformaparticipacaoconferencia text);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conferencia_outra(
id INTEGER, cdconferencia integer, ftconferencia text, nomeconferencia text, ftnomeconferencia text, 
dtanorealizacao date, ftanorealizacao text, cdformaparticipacaoconferencia integer, 
ftformaparticipacaoconferencia text, oficial boolean)


 RETURNS BOOLEAN AS $$

DECLARE
	idconferencia INTEGER;
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_participacao_social_conferencia (id_conferencia, cd_conferencia, ft_conferencia, id_osc, dt_ano_realizacao, ft_ano_realizacao, cd_forma_participacao_conferencia, ft_forma_participacao_conferencia, bo_oficial) 
	VALUES (DEFAULT, cdconferencia, ftconferencia, id, dtanorealizacao, ftanorealizacao, cdformaparticipacaoconferencia, ftformaparticipacaoconferencia, oficial) 
	RETURNING id_conferencia INTO idconferencia;	
 
	INSERT INTO osc.tb_participacao_social_conferencia_outra (tx_nome_conferencia, ft_nome_conferencia, id_conferencia) 
	VALUES (nomeconferencia, ftnomeconferencia, idconferencia);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
