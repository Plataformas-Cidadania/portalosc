var express = require('express'),
  path = require('path'),
  router  = express.Router();

router.use(require('./osc'));
router.use(require('./user'));

router.get('/', function(req,res){
  res.sendfile(path.resolve('client/html/index.html'));
});

module.exports = router;
