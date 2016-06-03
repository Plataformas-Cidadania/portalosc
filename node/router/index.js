var express = require('express'),
    router  = express.Router();

router.use(require('./osc'));
router.get('/', function(req,res){
    res.send('Página Inicial');
});

module.exports = router;
