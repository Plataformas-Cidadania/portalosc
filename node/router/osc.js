var express = require('express'),
    router  = express.Router();

router.get('/osc',function(req,res){
    //res.render('osc.html');
    res.send('Página OSC');
});

module.exports = router;
