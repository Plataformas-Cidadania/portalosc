DROP FUNCTION IF EXISTS portal.excluir_projeto(id integer);

CREATE OR REPLACE FUNCTION portal.excluir_projeto(id INTEGER) RETURNS VOID AS $$ 

DECLARE
	id_outra INTEGER;
	id_publico INTEGER;
	id_declarada INTEGER;
	
BEGIN 

	id_publico := (SELECT id_publico_beneficiado FROM osc.tb_publico_beneficiado_projeto WHERE id_projeto = id);

	DELETE FROM  
		osc.tb_publico_beneficiado_projeto 
	WHERE 
		id_publico_beneficiado = id_publico;
		

	DELETE FROM 
		 osc.tb_publico_beneficiado
	WHERE 
		id_publico_beneficiado = id_publico;
		

	DELETE FROM 
		 osc.tb_area_atuacao_projeto
	WHERE 
		id_projeto = id;
		

	id_outra := (SELECT id_area_atuacao_outra FROM osc.tb_area_atuacao_outra_projeto WHERE id_projeto = id);

	DELETE FROM 
		 osc.tb_area_atuacao_outra_projeto
	WHERE 
		id_area_atuacao_outra = id_outra;
		

	id_declarada := (SELECT id_area_atuacao_declarada FROM osc.tb_area_atuacao_outra WHERE id_area_atuacao_outra = id_outra);

	DELETE FROM  
		osc.tb_area_atuacao_outra 
	WHERE 
		id_area_atuacao_declarada = id_declarada;
		

	DELETE FROM  
		osc.tb_area_atuacao_declarada 
	WHERE 
		id_area_atuacao_declarada = id_declarada;
		

	DELETE FROM 
		osc.tb_localizacao_projeto 
	WHERE 
		id_projeto = id;
		

	DELETE FROM  
		osc.tb_objetivo_projeto 
	WHERE 
		id_projeto = id;
		

	DELETE FROM 
		osc.tb_osc_parceira_projeto
	WHERE 
		id_projeto = id;
		

	DELETE FROM 
		osc.tb_financiador_projeto 
	WHERE 
		id_projeto = id;
		

	DELETE FROM 
		osc.tb_fonte_recursos_projeto 
	WHERE 
		id_projeto = id;
		

	DELETE FROM 
		osc.tb_projeto
	WHERE 
		id_projeto = id;
RETURN;
END; 
$$ LANGUAGE 'plpgsql';
