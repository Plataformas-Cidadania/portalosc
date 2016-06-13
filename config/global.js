function setGlobal(rootPath){
	global.rootPath = rootPath;

	global.rootRequire = function(name) {
	    return require(rootPath + '/' + name);
	}

/*	process.on('uncaughtException', function(error){
		console.log('ocorreu um erro.');
	});*/
}

module.exports = {
	setGlobal: setGlobal
}
