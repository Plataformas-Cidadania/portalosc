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

function getPositionOSC(res, id){
	pg.connect(con, function(error, client, done) {
		if(error) {
			return console.error('error fetching client from pool', error);
		}
		
		var config = {
			client: client,
			res: res,
			done: done
		}
		
		var sql = 'SELECT ST_Y(bosc_geometry) AS lat, ST_X(bosc_geometry) AS lng ' +
		  		  'FROM data.tb_osc ' +
		  		  'WHERE bosc_sq_osc = ' + id;
		
		query(config, sql);
	});
};

module.exports = {
	getPositionOSC: getPositionOSC
}