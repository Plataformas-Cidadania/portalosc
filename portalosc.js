require('./admin/global').setGlobal(__dirname);

var express = require('express'),
	fs 		= require('fs'),
	app     = express(),
	port    = process.env.PORT || 3000;

app.use(function (req, res, next) {
	res.header('Access-Control-Allow-Origin', '*');
	res.header('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE');
	res.header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, XMLHttpRequest');
	next();
});

app.use(express.static(rootPath + '/client/'));

var serverPath = rootPath + '/server/';
fs.readdir(serverPath, function (err, files) {
    if (err) {
        throw new Error(err);
    }
    files.forEach(function (component) {
    	try {
    		app.use(require(serverPath + component));
        	console.log('Módulo ' + component + ' levantado');
    	}catch(e){
        	console.log('Ocorreu um erro ao levantar o módulo ' + component);
    	}
    });
});

app.listen(port, function(){
	console.log('Portal OSC rodando na porta ' + port);
});