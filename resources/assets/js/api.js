import axios from 'axios';
// import qs from 'qs';

// const baseUrl = 'http://laravel-passport-demo.test';
const baseUrl = 'https://laravel-passport-demo.herokuapp.com';
const Axios = axios.create({
	baseURL: baseUrl,
	timeout: 3000,
	headers: {
		'Content-Type': 'application/json',
		'Access-Control-Allow-Origin': '*',
		'Authorization': 'Bearer ' + localStorage.token,
	}
});

export default {
	register: function (params) {
		return Axios.post('/api/register', params);
	},

	login: function (params) {
		return Axios.post('/oauth/token', {
			username: params.email,
			type: params.type,
			password: params.password,
			guard: params.type,
			client_id: 2,
			client_secret: 'bjdSbRCb6ES6EzxvOfruK3uA1dm8GQzzcQACIg9l',
			grant_type: 'password',
		});
	},

	teacher: function () {
		return Axios.get('/api/teacher');
	},

	student: function () {
		return Axios.get('/api/teacher');
	},
};
