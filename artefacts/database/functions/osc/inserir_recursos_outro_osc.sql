DROP FUNCTION IF EXISTS portal.inserir_recursos_outro_osc(idosc INTEGER, txnomefonterecursos TEXT, ftnomefonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_recursos_outro_osc(idosc INTEGER, txnomefonterecursos TEXT, ftnomefonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT)
RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_recursos_outro_osc(id_osc, tx_nome_fonte_recursos_outro_osc, ft_nome_fonte_recursos_outro_osc, dt_ano_recursos_outro_osc, ft_ano_recursos_outro_osc, nr_valor_recursos_outro_osc, ft_valor_recursos_outro_osc) 
	VALUES (idosc, txnomefonterecursos, ftnomefonterecursos, dtanorecursos, ftanorecursos, nrvalorrecursos, ftvalorrecursos);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
