var db = rootRequire('./database/user');

function getUser(req, res){
	var id = req.params.id;
	db.getUser(res, id);
};

module.exports = {
	getUser: getUser
}