var express = require('express'),
	services = require('./services'),
	router  = express.Router();

router.get('/osc/:id', services.getOSC);

module.exports = {
	router: router
}