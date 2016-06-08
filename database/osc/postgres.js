var pg 		 = require('pg'),
	pgParams = rootRequire('./admin/secret').dbPostgres,
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

module.exports = {  
	getOSC: getOSC
}