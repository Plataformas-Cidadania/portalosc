function setGlobal(rootPath){
	global.rootPath = rootPath;
	global.rootRequire = function(name) {
	    return require(rootPath + '/' + name);
	}
}

module.exports = {  
	setGlobal: setGlobal
}