var db = rootRequire('./database/map');

function getPositionOSC(req, res){
	var id = req.params.id;
	db.getPositionOSC(res, id);
};

module.exports = {
	getPositionOSC: getPositionOSC
}