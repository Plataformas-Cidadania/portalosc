DELETE FROM syst.dc_origem_fonte_recursos_osc;
DELETE FROM syst.syst.dc_fonte_recursos_projeto;

INSERT INTO syst.dc_origem_fonte_recursos_osc (cd_origem_fonte_recursos_projeto, tx_nome_origem_fonte_recursos_projeto) 
VALUES (1, 'Recursos públicos');

INSERT INTO syst.dc_origem_fonte_recursos_osc (cd_origem_fonte_recursos_projeto, tx_nome_origem_fonte_recursos_projeto) 
VALUES (2, 'Recursos privados');

INSERT INTO syst.dc_origem_fonte_recursos_osc (cd_origem_fonte_recursos_projeto, tx_nome_origem_fonte_recursos_projeto) 
VALUES (3, 'Recursos próprios');

INSERT INTO syst.dc_origem_fonte_recursos_osc (cd_origem_fonte_recursos_projeto, tx_nome_origem_fonte_recursos_projeto) 
VALUES (4, 'Outros');
