import axios from 'axios'

const baseUrl = 'http://laravel-passport-demo.test';
// const baseUrl = 'https://laravel-passport-demo.herokuapp.com';

export default {
	register: function (params) {
		return axios.post(baseUrl + '/api/register', params);
	},

	login: function (params) {
		return axios.post(baseUrl + '/oauth/token', {
			username: params.email,
			type: params.type,
			password: params.password,
			guard: params.type,
			client_id: 2,
			client_secret: 'bjdSbRCb6ES6EzxvOfruK3uA1dm8GQzzcQACIg9l',
			grant_type: 'password',
		});
	},

	userInfo: function (params) {
		return axios.get(baseUrl + '/api/user');
	}
};
