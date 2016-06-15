var pg 		 = require('pg'),
	pgParams = rootRequire('./config/secret').dbPostgres,
	con 	 = 'postgres://' + pgParams.user + ':' + pgParams.password + '@' + pgParams.host + '/' + pgParams.name;

function getOSC(id, callback){
	pg.connect(con, function(error, client, done) {
		if(error) {
			return console.error('error fetching client from pool', error);
		}
		
		var sql = 'SELECT * ' + 
				  'FROM portal.vm_osc_principal ' + 
				  'WHERE bosc_sq_osc = ' + id;
		
		client.query(sql, function(error, result) {
			done();
			if(error) {
				return console.error('error running query', error);
			}
			callback(result.rows[0]);
		});
	});
};

function updateOSC(osc, callback){
	pg.connect(con, function(error, client, done) {
		if(error) {
			console.error('error fetching client from pool', error);
			callback(true);
		}
		
		sql = 'UPDATE portal.vm_osc_principal SET ' +
			  'bosc_nm_fantasia_osc = ' + osc.nome_fantasia + ', ' +
			  'ospr_tx_descricao = ' + osc.descricao + ', ' +
			  'ospr_dt_ano_fundacao = ' + osc.ano_fundacao + ', ' +
			  'ospr_ee_site = ' + osc.site + ', ' +
			  'ee_google = ' + osc.google + ', ' +
			  'ee_facebook = ' + osc.facebook + ', ' +
			  'ee_linkedin = ' + osc.linkedin + ', ' +
			  'ee_twitter = ' + osc.twitter + ', ' +
			  'WHERE bosc_sq_osc = ' + osc.id;
		
		client.query(sql, function(error, result) {
			done();
			if(error) {
				console.error('error running query', error);
				callback(true);
			}
			callback(false);
		});
	});
};

module.exports = {  
	getOSC: getOSC,
	updateOSC: updateOSC
}