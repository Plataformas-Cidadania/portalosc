DELETE FROM syst.dc_fonte_recursos_projeto;
DELETE FROM syst.dc_origem_fonte_recursos_osc;

INSERT INTO syst.dc_origem_fonte_recursos_osc (tx_nome_origem_fonte_recursos_osc) 
VALUES ('Recursos p�blicos');

INSERT INTO syst.dc_origem_fonte_recursos_osc (tx_nome_origem_fonte_recursos_osc) 
VALUES ('Recursos privados');

INSERT INTO syst.dc_origem_fonte_recursos_osc (tx_nome_origem_fonte_recursos_osc) 
VALUES ('Recursos pr�prios');

INSERT INTO syst.dc_origem_fonte_recursos_osc (tx_nome_origem_fonte_recursos_osc) 
VALUES ('Outros');