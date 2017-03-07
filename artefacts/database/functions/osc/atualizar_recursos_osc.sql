DROP FUNCTION IF EXISTS portal.atualizar_recursos_osc(idosc INTEGER, idrecursos INTEGER, cdfonterecursos INTEGER, ftfonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_recursos_osc(idosc INTEGER, idrecursos INTEGER, cdfonterecursos INTEGER, ftfonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT)
 RETURNS TABLE(
	status BOOLEAN,
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_recursos_osc
	SET 
		id_osc = idosc, 
		cd_fonte_recursos_osc = cdfonterecursos, 
		ft_fonte_recursos_osc = ftfonterecursos, 
		dt_ano_recursos_osc = dtanorecursos, 
		ft_ano_recursos_osc = ftanorecursos, 
		nr_valor_recursos_osc = nrvalorrecursos, 
		ft_valor_recursos_osc = ftvalorrecursos
	WHERE 
		id_recursos_osc = idrecursos; 
	
	status := true;
	mensagem := 'Recursos da OSC atualizado.';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
