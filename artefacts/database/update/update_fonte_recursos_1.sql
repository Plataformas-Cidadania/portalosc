/*
 *	ATUALIZAÇÃO syst.dc_origem_fonte_recursos_osc
 */
UPDATE syst.dc_origem_fonte_recursos_osc 
SET tx_nome_origem_fonte_recursos_osc = 'Recursos não financeiros' 
WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos internacionais';

UPDATE syst.dc_origem_fonte_recursos_osc 
SET tx_nome_origem_fonte_recursos_osc = 'Recursos públicos' 
WHERE tx_nome_origem_fonte_recursos_osc ILIKE '%blicos';

UPDATE syst.dc_origem_fonte_recursos_osc 
SET tx_nome_origem_fonte_recursos_osc = 'Recursos próprios' 
WHERE tx_nome_origem_fonte_recursos_osc ILIKE '%prios';



/*
 *	ATUALIZAÇÃO syst.dc_origem_fonte_recursos_projeto
 */
UPDATE syst.dc_origem_fonte_recursos_projeto 
SET tx_nome_origem_fonte_recursos_projeto = 'Recursos não financeiros' 
WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos internacionais';

UPDATE syst.dc_origem_fonte_recursos_projeto 
SET tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos' 
WHERE tx_nome_origem_fonte_recursos_projeto ILIKE '%blicos';

UPDATE syst.dc_origem_fonte_recursos_projeto 
SET tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios' 
WHERE tx_nome_origem_fonte_recursos_projeto ILIKE '%prios';



/*
 *	ATUALIZAÇÃO syst.dc_fonte_recursos_osc / Recursos públicos
 */
UPDATE syst.dc_fonte_recursos_osc 
SET 
	tx_nome_fonte_recursos_osc = 'Parceria com o governo federal', 
	cd_origem_fonte_recursos_osc = (SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_osc = 'Público Federal';

UPDATE syst.dc_fonte_recursos_osc 
SET 
	tx_nome_fonte_recursos_osc = 'Parceria com o governo estadual', 
	cd_origem_fonte_recursos_osc = (SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_osc = 'Público Estadual';

UPDATE syst.dc_fonte_recursos_osc 
SET 
	tx_nome_fonte_recursos_osc = 'Parceria com o governo municipal', 
	cd_origem_fonte_recursos_osc = (SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_osc = 'Público Municipal';

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos'), 
	'Acordo com organismos multilaterais '
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos'), 
	'Acordo com organismos multilaterais'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos'), 
	'Acordo com governos estrangeiros'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos'), 
	'Empresas públicas ou sociedades de economia mista'
);



/*
 *	ATUALIZAÇÃO syst.dc_fonte_recursos_projeto / Recursos públicos
 */
UPDATE syst.dc_fonte_recursos_projeto 
SET 
	tx_nome_fonte_recursos_projeto = 'Parceria com o governo federal', 
	cd_origem_fonte_recursos_projeto = (SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_projeto = 'Público Federal';

UPDATE syst.dc_fonte_recursos_projeto 
SET 
	tx_nome_fonte_recursos_projeto = 'Parceria com o governo estadual', 
	cd_origem_fonte_recursos_projeto = (SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_projeto = 'Público Estadual';

UPDATE syst.dc_fonte_recursos_projeto 
SET 
	tx_nome_fonte_recursos_projeto = 'Parceria com o governo municipal', 
	cd_origem_fonte_recursos_projeto = (SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_projeto = 'Público Municipal';

DELETE FROM syst.dc_fonte_recursos_projeto WHERE tx_nome_fonte_recursos_projeto = 'Acordo com organismos multilaterais';
INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos'), 
	'Acordo com organismos multilaterais'
);

DELETE FROM syst.dc_fonte_recursos_projeto WHERE tx_nome_fonte_recursos_projeto = 'Acordo com governos estrangeiros';
INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos'), 
	'Acordo com governos estrangeiros'
);

DELETE FROM syst.dc_fonte_recursos_projeto WHERE tx_nome_fonte_recursos_projeto = 'Empresas públicas ou sociedades de economia mista';
INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos'), 
	'Empresas públicas ou sociedades de economia mista'
);



/*
 *	ATUALIZAÇÃO syst.dc_fonte_recursos_projeto / Recursos públicos
 */
UPDATE syst.dc_fonte_recursos_projeto 
SET 
	tx_nome_fonte_recursos_projeto = 'Parceria com o governo federal', 
	cd_origem_fonte_recursos_projeto = (SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_projeto = 'Público Federal';

UPDATE syst.dc_fonte_recursos_projeto 
SET 
	tx_nome_fonte_recursos_projeto = 'Parceria com o governo estadual', 
	cd_origem_fonte_recursos_projeto = (SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_projeto = 'Público Estadual';

UPDATE syst.dc_fonte_recursos_projeto 
SET 
	tx_nome_fonte_recursos_projeto = 'Parceria com o governo municipal', 
	cd_origem_fonte_recursos_projeto = (SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos') 
WHERE tx_nome_fonte_recursos_projeto = 'Público Municipal';

DELETE FROM syst.dc_fonte_recursos_projeto WHERE tx_nome_fonte_recursos_projeto = 'Acordo com organismos multilaterais';
INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos'), 
	'Acordo com organismos multilaterais'
);

DELETE FROM syst.dc_fonte_recursos_projeto WHERE tx_nome_fonte_recursos_projeto = 'Acordo com governos estrangeiros';
INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos'), 
	'Acordo com governos estrangeiros'
);

DELETE FROM syst.dc_fonte_recursos_projeto WHERE tx_nome_fonte_recursos_projeto = 'Empresas públicas ou sociedades de economia mista';
INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos'), 
	'Empresas públicas ou sociedades de economia mista'
);



/*
 *	DELETE syst.dc_fonte_recursos_osc
 */
DELETE FROM syst.dc_fonte_recursos_osc 
WHERE cd_origem_fonte_recursos_osc != (SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos públicos');

DELETE FROM syst.dc_fonte_recursos_projeto 
WHERE cd_origem_fonte_recursos_projeto != (SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos públicos');



/*
 *	ATUALIZAÇÃO syst.dc_fonte_recursos_osc / Recursos próprios
 */
INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos próprios'), 
	'Rendimentos de fundos patrimoniais'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos próprios'), 
	'Rendimentos financeiros de reservas ou contas correntes  próprias'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos próprios'), 
	'Mensalidades ou contribuições de associados'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos próprios'), 
	'Prêmios recebidos'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos próprios'), 
	'Venda de produtos'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos próprios'), 
	'Prestação de serviços'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos próprios'), 
	'Venda de bens e direitos'
);



INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios'), 
	'Rendimentos de fundos patrimoniais'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios'), 
	'Rendimentos financeiros de reservas ou contas correntes  próprias'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios'), 
	'Mensalidades ou contribuições de associados'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios'), 
	'Prêmios recebidos'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios'), 
	'Venda de produtos'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios'), 
	'Prestação de serviços'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos próprios'), 
	'Venda de bens e direitos'
);



/*
 *	ATUALIZAÇÃO syst.dc_fonte_recursos_osc / Recursos privados
 */
INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Parceria com OSCs brasileiras'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Parcerias com OSCs estrangeiras'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Parcerias com organizações religiosas brasileiras'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Parcerias com organizações religiosas estrangeiras'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Empresas privadas brasileiras'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Empresas estrangeiras'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Doações de pessoa jurídica'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Doações de pessoa física'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos privados'), 
	'Doações recebidas na forma de produtos e serviços (com Nota Fiscal)'
);



INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Parceria com OSCs brasileiras'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Parcerias com OSCs estrangeiras'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Parcerias com organizações religiosas brasileiras'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Parcerias com organizações religiosas estrangeiras'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Empresas privadas brasileiras'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Doações de pessoa jurídica'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Venda de bens e direitos'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Doações de pessoa física'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos privados'), 
	'Doações recebidas na forma de produtos e serviços (com Nota Fiscal)'
);



/*
 *	ATUALIZAÇÃO syst.dc_fonte_recursos_osc / Recursos não financeiros
 */
INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos não financeiros'), 
	'Voluntariado'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos não financeiros'), 
	'Isenções'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos não financeiros'), 
	'Imunidades'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos não financeiros'), 
	'Bens recebidos em direito de uso'
);

INSERT INTO syst.dc_fonte_recursos_osc (cd_origem_fonte_recursos_osc, tx_nome_fonte_recursos_osc) 
VALUES (
	(SELECT cd_origem_fonte_recursos_osc FROM syst.dc_origem_fonte_recursos_osc WHERE tx_nome_origem_fonte_recursos_osc = 'Recursos não financeiros'), 
	'Doações recebidas na forma de produtos e serviços (sem Nota Fiscal)'
);



INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos não financeiros'), 
	'Voluntariado'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos não financeiros'), 
	'Isenções'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos não financeiros'), 
	'Imunidades'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos não financeiros'), 
	'Bens recebidos em direito de uso'
);

INSERT INTO syst.dc_fonte_recursos_projeto (cd_origem_fonte_recursos_projeto, tx_nome_fonte_recursos_projeto) 
VALUES (
	(SELECT cd_origem_fonte_recursos_projeto FROM syst.dc_origem_fonte_recursos_projeto WHERE tx_nome_origem_fonte_recursos_projeto = 'Recursos não financeiros'), 
	'Doações recebidas na forma de produtos e serviços (sem Nota Fiscal)'
);