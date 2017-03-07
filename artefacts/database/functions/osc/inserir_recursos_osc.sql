DROP FUNCTION IF EXISTS portal.inserir_recursos_osc(idosc INTEGER, cdfonterecursos INTEGER, ftfonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT);

CREATE OR REPLACE FUNCTION portal.inserir_recursos_osc(idosc INTEGER, cdfonterecursos INTEGER, ftfonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT)
RETURNS BOOLEAN AS $$

DECLARE
	status BOOLEAN;	

BEGIN
	INSERT INTO osc.tb_recursos_osc(id_osc, cd_fonte_recursos_osc, ft_fonte_recursos_osc, dt_ano_recursos_osc, ft_ano_recursos_osc, nr_valor_recursos_osc, ft_valor_recursos_osc) 
	VALUES (idosc, cdfonterecursos, ftfonterecursos, dtanorecursos, ftanorecursos, nrvalorrecursos, ftvalorrecursos);

	status := true;
	RETURN status;

EXCEPTION 
	WHEN others THEN 
		status := false;
		RETURN status;

END;
$$ LANGUAGE 'plpgsql';
