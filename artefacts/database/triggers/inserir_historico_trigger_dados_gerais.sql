DROP FUNCTION IF EXISTS log.inserir_historico_trigger_dados_gerais(id INTEGER, fonte TEXT, registro_posterior JSON);

CREATE OR REPLACE FUNCTION log.inserir_historico_trigger_dados_gerais(id INTEGER, fonte TEXT, registro_posterior JSON) RETURNS VOID AS $$

DECLARE
	registro_anterior INTEGER;

BEGIN
	registro_anterior := (
		SELECT row_to_json(t) AS registro
		FROM (
			SELECT * 
			FROM osc.tb_dados_gerais 
			WHERE id_osc = id
		) t
	);
	
	INSERT INTO 
		log.tb_historico (id_tabela, tx_nome_tabela, id_fonte, js_registro_anterior, js_registro_posterior, dt_atualizacao)
	VALUES
		(id, 'osc.tb_dados_gerais', fonte, registro_anterior, registro_posterior, now());

EXCEPTION 
	WHEN not_null_violation THEN 
		status := false;
		mensagem := 'Campo(s) obrigatório(s) não foram preenchido(s).';
		RETURN NEXT;

	WHEN unique_violation THEN 
		status := false;
		mensagem := 'Unicidade(s) violada(s).';
		RETURN NEXT;

	WHEN others THEN 
		status := false;
		mensagem := 'Ocorreu um erro.';
		RETURN NEXT;

END;
$$ LANGUAGE 'plpgsql';