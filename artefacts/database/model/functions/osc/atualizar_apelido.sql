DROP FUNCTION IF EXISTS portal.atualizar_apelido(id INTEGER, apelido TEXT, ftapelido TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_apelido(id INTEGER, apelido TEXT, ftapelido TEXT) 
 RETURNS VOID AS $$ 

BEGIN 
	UPDATE 
		osc.tb_osc
	SET 
		tx_apelido_osc = apelido,
    		ft_apelido_osc = ftapelido
		 
	WHERE 
		id_osc = id; 
END; 
$$ LANGUAGE 'plpgsql';
