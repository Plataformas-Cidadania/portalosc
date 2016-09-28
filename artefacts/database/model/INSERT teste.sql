INSERT INTO osc.tb_osc (cd_identificador_osc, ft_identificador_osc, bo_osc_ativa,  ft_osc_ativa)
VALUES (12345678901234, 'RAIS', true, 'RAIS');

INSERT INTO osc.tb_dados_gerais (id_osc, tx_razao_social_osc, ft_razao_social_osc, tx_nome_fantasia_osc, ft_nome_fantasia_osc, tx_resumo_osc, ft_resumo_osc)
VALUES ((SELECT id_osc FROM osc.tb_osc WHERE cd_identificador_osc = 12345687901234), 'Organização Teste', 'RAIS', 'OrgTest', 'RAIS', 'Organização usada para os testes de desenvolvimento.', 'Usuário Teste');

INSERT INTO portal.tb_usuario (tx_email_usuario, tx_senha_usuario, tx_nome_usuario, nr_cpf_usuario, bo_lista_email, bo_ativo, dt_cadastro, dt_atualizacao)
VALUES ('vagnerpraia@gmail.com', '123456', 'Vagner Praia', '12345678901', true, true, NOW(), NOW());

INSERT INTO portal.tb_representacao (id_osc, id_usuario)
VALUES (2, 1);