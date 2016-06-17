var express = require('express'),
	services = require('./services'),
	router = express.Router();

router.get('/osc/:id', services.getOSC);
router.put('/osc/:id', services.updateOSC);

module.exports = {
	router: router
}
