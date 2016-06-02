module.exports = function(app)
{
     app.get('/',function(req,res){
        //res.render('portalosc.html');
        res.send('Página Inicial');
     });
     app.get('/osc',function(req,res){
        //res.render('osc.html');
        res.send('Página OSC');
    });
};
