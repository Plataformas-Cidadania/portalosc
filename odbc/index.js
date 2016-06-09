var express = require('express');

module.exports = {
	osc: require('./osc'),
	getUser: require('./user').getUser
}