var express = require('express'),
	router  = express.Router(),
	services = require('./services');

router.get('/map/osc/:id', services.getPositionOSC);

module.exports = {
	router: router
}