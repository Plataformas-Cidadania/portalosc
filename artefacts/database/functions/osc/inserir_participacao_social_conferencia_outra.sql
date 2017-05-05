DROP FUNCTION IF EXISTS portal.inserir_participacao_social_conferencia_outra(id integer, nomeconferenciadeclarada text, ftconferenciadeclarada text, ftconferenciadeclaradaoutra text, dtanorealizacao date, ftanorealizacao text, cdformaparticipacaoconferencia integer, ftformaparticipacaoconferencia text);

CREATE OR REPLACE FUNCTION portal.inserir_participacao_social_conferencia_outra(
nomeconferencia text, ftnomeconferencia text, idconferencia integer)


 RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN 
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
