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
				  'WHERE bosc_sq_osc = $1::int';
		
		var values = [id];
		
		client.query(sql, values, function(error, result) {
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
		
		var sql = 'UPDATE portal.vm_osc_principal SET ' +
			  	  'bosc_nm_fantasia_osc = $1::text,' +
			  	  'ospr_tx_descricao = $2::text,' +
			  	  'ospr_dt_ano_fundacao = $3::int, ' +
			  	  'ospr_ee_site = $4::text, ' +
			  	  'ee_google = $5::text, ' +
			  	  'ee_facebook = $6::text, ' +
			  	  'ee_linkedin = $7::text, ' +
			  	  'ee_twitter = $8::text, ' +
			  	  'WHERE bosc_sq_osc = $9::int';
		
		var values = [osc.nome_fantasia, osc.descricao, osc.ano_fundacao, osc.site, osc.google, osc.facebook, osc.linkedin, osc.twitter, osc.id];
		
		client.query(sql, values, function(error, result) {
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