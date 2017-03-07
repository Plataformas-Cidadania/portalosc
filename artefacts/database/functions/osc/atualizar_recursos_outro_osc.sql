DROP FUNCTION IF EXISTS portal.atualizar_recursos_outro_osc(idosc INTEGER, idrecursos INTEGER, txnomefonterecursos TEXT, ftnomefonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_recursos_outro_osc(idosc INTEGER, idrecursos INTEGER, txnomefonterecursos TEXT, ftnomefonterecursos TEXT, dtanorecursos DATE, ftanorecursos TEXT, nrvalorrecursos DOUBLE PRECISION, ftvalorrecursos TEXT)
 RETURNS TABLE(
	status BOOLEAN,
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_recursos_outro_osc
	SET 
		id_osc = idosc, 
		tx_nome_fonte_recursos_outro_osc = txnomefonterecursos, 
		ft_nome_fonte_recursos_outro_osc = ftnomefonterecursos, 
		dt_ano_recursos_outro_osc = dtanorecursos, 
		ft_ano_recursos_outro_osc = ftanorecursos, 
		nr_valor_recursos_outro_osc = nrvalorrecursos, 
		ft_valor_recursos_outro_osc = ftvalorrecursos
	WHERE 
		id_recursos_outro_osc = idrecursos; 
	
	status := true;
	mensagem := 'Recursos da OSC atualizado.';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
