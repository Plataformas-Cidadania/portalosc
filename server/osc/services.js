var db = rootRequire('./odbc'),
	path = require('path');

function getOSC(req, res) {
	var id = req.params.id;
	var json = {"id" : id, "name" : "terra dos homens"};
	/*db.osc.getOSC(id, function(result){
		res.json(result);
	});*/
	res.json(json);
}

module.exports = {
	getOSC: getOSC
}
