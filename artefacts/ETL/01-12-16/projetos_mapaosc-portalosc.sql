select distinct d.bosc_nr_identificacao,b.titulo,'Representante' as ft_nome_projeto, CASE when b.status = 'Planejado' then 1 when b.status = 'Em Execução' then 2 else 3 end as status_projeto, 'Representante' as ft_status_projeto, 
b.data_inicio, 'Representante' as ft_dt_ini_projeto, b.data_fim, 'Representante' as ft_dt_fim_projeto, b.link, 'Representante' as ft_link,case when b.valor_total<0 then 0 else b.valor_total end as valor_total , 'Representante' as ft_valor_projeto, case when b.abrangencia = 'Municipal' then 1 when b.abrangencia = 'Estadual' then 2 when b.abrangencia = 'Regional' then 3 end as abrangencia_projeto,
'Representante' as ft_abrangencia, b.descricao, 'Representante' as ft_descricao, false as bo_oficial, COALESCE(c.edmu_cd_municipio, c.edre_cd_regiao) as id_localizacao, 'Representante' as ft_localizacao
from data.tb_ternaria_projeto a
inner join data.tb_osc_projeto b on a.proj_cd_projeto = b.proj_cd_projeto
left join data.tb_osc_projeto_loc c on b.proj_cd_projeto = c.proj_cd_projeto
inner join data.tb_osc d on a.bosc_sq_osc = d.bosc_sq_osc
where (b.titulo = '' and b.valor_total > 0) or b.titulo <> '' -- (c.edre_cd_regiao is not null or c.eduf_cd_uf is not null or c.edmu_cd_municipio is not null)

  *id_osc,
  tx_nome_projeto,
  ft_nome_projeto,
  cd_status_projeto,
  ft_status_projeto,
  dt_data_inicio_projeto,
  ft_data_inicio_projeto,
  dt_data_fim_projeto,
  ft_data_fim_projeto,
  tx_link_projeto,
  ft_link_projeto,
  *nr_total_beneficiarios,
  *ft_total_beneficiarios,
  *nr_valor_captado_projeto,
  *ft_valor_captado_projeto,
  nr_valor_total_projeto,
  ft_valor_total_projeto,
  cd_abrangencia_projet,
  ft_abrangencia_projeto,
  *cd_zona_atuacao_projeto,
  *ft_zona_atuacao_projeto,
  tx_descricao_projeto,
  ft_descricao_projeto,
  *ft_metodologia_monitoramento,
  *tx_metodologia_monitoramento,
  *tx_identificador_projeto_externo,
  *ft_identificador_projeto_externo,
  bo_oficial


select distinct COALESCE(c.edmu_cd_municipio, c.edre_cd_regiao) as id_localizacao
from data.tb_ternaria_projeto a
inner join data.tb_osc_projeto b on a.proj_cd_projeto = b.proj_cd_projeto
inner join data.tb_osc_projeto_loc c on b.proj_cd_projeto = c.proj_cd_projeto
inner join data.tb_osc d on a.bosc_sq_osc = d.bosc_sq_osc
where c.edre_cd_regiao is not null or c.eduf_cd_uf is not null or c.edmu_cd_municipio is not null

  id_projeto,
  id_regiao_localizacao_projeto,
  ft_regiao_localizacao_projeto,
  tx_nome_regiao_localizacao_projeto,
  ft_nome_regiao_localizacao_projeto,
  bo_localizacao_prioritaria,
  ft_localizacao_prioritaria,
  bo_oficial
