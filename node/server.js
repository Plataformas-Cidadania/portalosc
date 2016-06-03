var express = require('express'),
    app     = express(),
    port    = process.env.PORT || 3000;

app.use(require('./router/index'));

app.listen(port);
console.log('Servidor rodando na porta 3000');
/*var server     =    app.listen(3000,function(){
console.log("Express is running on port 3000");
});*/
