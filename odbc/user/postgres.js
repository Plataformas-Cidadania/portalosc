var pg 		 = require('pg'),
	pgParams = rootRequire('./admin/secret').dbPostgres,
	con 	 = 'postgres://' + pgParams.user + ':' + pgParams.password + '@' + pgParams.host + '/' + pgParams.name;

function getUser(id, callback){
	pg.connect(con, function(error, client, done) {
		if(error) {
			return console.error('error fetching client from pool', error);
		}
		
		var sql = 'SELECT * ' + 
		  		  'FROM portal.tb_usuario ' + 
		  		  'WHERE tusu_sq_usuario = ' + id;
		
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
	getUser: getUser
}