UPDATE osc.tb_projeto SET dt_data_inicio_projeto = null where dt_data_inicio_projeto = '0001-01-01 BC';
UPDATE osc.tb_projeto SET dt_data_fim_projeto = null where dt_data_fim_projeto = '0001-01-01 BC';
DELETE FROM osc.tb_certificado WHERE ft_certificado = 'MS/SUS';

