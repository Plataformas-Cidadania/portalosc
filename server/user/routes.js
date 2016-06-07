var express = require('express'),
	router  = express.Router(),
	services = require('./services');

router.get('/user/:id', services.getUser);

module.exports = {
	router: router
}