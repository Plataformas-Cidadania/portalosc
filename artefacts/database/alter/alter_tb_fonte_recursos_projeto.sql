ALTER TABLE osc.tb_fonte_recursos_projeto 
ADD cd_origem_fonte_recursos_projeto INTEGER;

ALTER TABLE osc.tb_fonte_recursos_projeto 
ADD CONSTRAINT fk_cd_origem_fonte_recursos_projeto 
FOREIGN KEY (cd_origem_fonte_recursos_projeto) 
REFERENCES syst.dc_origem_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto);
