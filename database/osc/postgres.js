var pg 		 = require('pg'),
	pgParams = rootRequire('./admin/secret').dbPostgres,
	con 	 = 'postgres://' + pgParams.user + ':' + pgParams.password + '@' + pgParams.host + '/' + pgParams.name;

function query(config, sql){
	config.client.query(sql, function(error, result) {
		config.done();
		if(error) {
			return console.error('error running query', error);
		}
		config.res.send(result.rows[0]);
	});
}

function getOSC(res, id){
	pg.connect(con, function(error, client, done) {
		if(error) {
			return console.error('error fetching client from pool', error);
		}
		
		var config = {
			client: client,
			res: res,
			done: done
		}
		
		var sql = 'SELECT * ' + 
				  'FROM portal.vm_osc_principal ' + 
				  'WHERE bosc_sq_osc = ' + id;
		
		query(config, sql);
	});
};

module.exports = {  
	getOSC: getOSC
}