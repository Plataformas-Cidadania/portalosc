var db = rootRequire('./odbc');

function getOSC(req, res) {
	var id = req.params.id;
	db.osc.getOSC(id, function(result){
		res.send(result);
	});
}

module.exports = {  
	getOSC: getOSC
}