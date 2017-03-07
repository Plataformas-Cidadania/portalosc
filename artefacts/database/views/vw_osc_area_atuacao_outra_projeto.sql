-- object: portal.vw_osc_area_atuacao_outra_projeto | type: MATERIALIZED VIEW --
DROP MATERIALIZED VIEW IF EXISTS portal.vw_osc_area_atuacao_outra_projeto CASCADE;
CREATE MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra_projeto
AS

SELECT
	tb_area_atuacao_outra_projeto.id_projeto,
	tb_area_atuacao_outra_projeto.id_area_atuacao_outra_projeto,
	(
		SELECT tx_nome_area_atuacao_declarada
		FROM osc.tb_area_atuacao_declarada
		WHERE id_area_atuacao_declarada = (
			SELECT id_area_atuacao_declarada
			FROM osc.tb_area_atuacao_outra
			WHERE id_area_atuacao_outra = tb_area_atuacao_outra_projeto.id_area_atuacao_outra
		)
	) AS tx_nome_area_atuacao_outra_projeto,
	tb_area_atuacao_outra_projeto.ft_area_atuacao_outra_projeto
FROM osc.tb_osc
INNER JOIN osc.tb_projeto ON tb_projeto.id_osc = tb_osc.id_osc
INNER JOIN osc.tb_area_atuacao_outra_projeto ON tb_area_atuacao_outra_projeto.id_projeto = osc.tb_projeto.id_projeto
WHERE tb_osc.bo_osc_ativa;
-- ddl-end --
ALTER MATERIALIZED VIEW portal.vw_osc_area_atuacao_outra_projeto OWNER TO postgres;
-- ddl-end --