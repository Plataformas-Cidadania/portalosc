var db = rootRequire('./database/osc');

function getOSC(req, res){
	var id = req.params.id;
	db.getOSC(res, id);
};

module.exports = {  
	getOSC: getOSC
}