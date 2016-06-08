var express = require('express'),
    router  = express.Router();

router.use(require('./map'));
router.use(require('./osc'));
router.use(require('./user'));

module.exports = router;