var db = rootRequire('./database/map');

function getPositionOSC(req, res){
	var id = req.params.id;
	db.getPositionOSC(id, function(result){
		res.send(result);
	});
};

module.exports = {
	getPositionOSC: getPositionOSC
}