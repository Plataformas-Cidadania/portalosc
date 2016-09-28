CREATE OR REPLACE FUNCTION portal.update_representation(req_id_usuario INTEGER, req_id_osc INTEGER[]) RETURNS VOID AS $$
DECLARE
	row1 RECORD;
	row2 INTEGER;
BEGIN
	FOR row1 IN
		SELECT tb_representacao.id_representacao, tb_representacao.id_osc FROM portal.tb_representacao WHERE tb_representacao.id_usuario = req_id_usuario
	LOOP
		IF (SELECT row1.id_osc != ANY(req_id_osc)) THEN
			DELETE FROM portal.tb_representacao WHERE tb_representacao.id_usuario = id_usuario AND tb_representacao.id_osc = row1.id_osc;
		END IF;
	END LOOP;
	
	FOREACH row2 IN ARRAY req_id_osc
	LOOP
		IF NOT EXISTS(SELECT * FROM portal.tb_representacao WHERE id_osc = row2 AND id_usuario = req_id_usuario) THEN
			INSERT INTO
				portal.tb_representacao(id_osc, id_usuario)
			VALUES
				(row2, req_id_usuario);
		END IF;
	END LOOP;
END;
$$ LANGUAGE 'plpgsql'