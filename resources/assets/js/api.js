import axios from 'axios'

export default {
	register: function(params) {
		return axios.post('/api/register', {
			params: params,
		});
	}
};
