var siege = require('siege');

siege('node ../../portalosc.js')
.host('localhost')
.on(3000)
.concurrent(10)
.for(1000).times
.get('/osc/get/281141')
//.post('/osc/put', {id: 281141, dadosGerais: {nomeFantasia: 'Terra dos Homens', descricao: 'bla bla bla bla'}})
.attack();