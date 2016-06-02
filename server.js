var express = require('express');
var app     = express();

require('./router/main')(app);

var server     =    app.listen(3000,function(){
console.log("Express is running on port 3000");
});
