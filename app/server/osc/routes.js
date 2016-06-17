var express = require('express'),
	services = require('./services'),
	router = express.Router();
	
router.get('/osc/get/:id', services.getOSC);
router.post('/osc/put', services.updateOSC);

module.exports = {
	router: router
}