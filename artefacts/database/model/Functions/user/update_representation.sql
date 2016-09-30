CREATE OR REPLACE FUNCTION portal.update_representation(id_usuario_req INTEGER, id_osc_req INTEGER[]) RETURNS INTEGER[] AS $$
DECLARE
	id_osc_insert INTEGER;
	id_representacao_delete INTEGER;
	id_osc_res INTEGER[];
BEGIN
	FOREACH id_osc_insert IN ARRAY id_osc_req
	LOOP
		BEGIN
			INSERT INTO portal.tb_representacao(id_osc, id_usuario) VALUES (id_osc_insert, id_usuario_req);
			id_osc_res := array_append(id_osc_res, id_osc_insert);
		EXCEPTION WHEN unique_violation THEN
			RAISE NOTICE 'ERROR: unique_violation for id_usuario = % and id_osc = %', id_usuario_req, id_osc_insert;
		END;
	END LOOP;
	
	FOR id_representacao_delete IN
		SELECT id_representacao FROM portal.tb_representacao WHERE id_usuario = id_usuario_req AND id_osc <> ALL(id_osc_req)
	LOOP
		DELETE FROM portal.tb_representacao WHERE id_representacao = id_representacao_delete;
	END LOOP;
	
	RETURN id_osc_res;
END;
$$ LANGUAGE 'plpgsql'