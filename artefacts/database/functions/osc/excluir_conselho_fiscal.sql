DROP FUNCTION IF EXISTS portal.excluir_conselho_fiscal(id INTEGER);

CREATE OR REPLACE FUNCTION portal.excluir_conselho_fiscal(id INTEGER) RETURNS VOID AS $$ 
BEGIN 
	DELETE FROM 
		osc.tb_conselho_fiscal
	WHERE 
		id_conselheiro = id; 
END; 
$$ LANGUAGE 'plpgsql';
