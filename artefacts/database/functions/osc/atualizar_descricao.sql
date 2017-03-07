DROP FUNCTION IF EXISTS portal.atualizar_descricao(id INTEGER, historico TEXT, fthistorico TEXT, 
missao TEXT, ftmissao TEXT, visao TEXT, ftvisao TEXT, finalidadesestatutarias TEXT, ftfinalidadesestatutarias TEXT, 
linkestatuto TEXT, ftlinkestatuto TEXT);

CREATE OR REPLACE FUNCTION portal.atualizar_descricao(id INTEGER, historico TEXT, fthistorico TEXT, 
missao TEXT, ftmissao TEXT, visao TEXT, ftvisao TEXT, finalidadesestatutarias TEXT, ftfinalidadesestatutarias TEXT, 
linkestatuto TEXT, ftlinkestatuto TEXT) 
  RETURNS TABLE(
	mensagem TEXT
)AS $$

BEGIN 
	UPDATE 
		osc.tb_dados_gerais 
	SET 
		tx_historico = historico,
    		ft_historico = fthistorico, 
    		tx_missao_osc = missao, 
    		ft_missao_osc = ftmissao, 
    		tx_visao_osc = visao, 
    		ft_visao_osc = ftvisao, 
    		tx_finalidades_estatutarias = finalidadesestatutarias,
    		ft_finalidades_estatutarias = ftfinalidadesestatutarias, 
		tx_link_estatuto_osc = linkestatuto,
		ft_link_estatuto_osc = ftlinkestatuto
		 
	WHERE 
		id_osc = id; 

	mensagem := 'Descricao atualizada';
	RETURN NEXT;
END; 
$$ LANGUAGE 'plpgsql';
