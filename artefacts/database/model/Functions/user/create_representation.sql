CREATE OR REPLACE FUNCTION portal.create_representation(id_osc INTEGER, id_usuario INTEGER) RETURNS VOID AS $$
BEGIN
	INSERT INTO
		portal.tb_representacao (id_osc, id_usuario)
	VALUES
		(idosc, idusuario);
END;
$$ LANGUAGE 'plpgsql'