var db = rootRequire('./odbc/user');

function getUser(req, res){
	var id = req.params.id;
	db.getUser(id, function(result){
		res.send(result);
	});
};

module.exports = {
	getUser: getUser
}