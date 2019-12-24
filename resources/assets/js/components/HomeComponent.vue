<template>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">个人中心</div>
					<div class="panel-body">
						<ul class="list-group col-md-6">
							<li class="list-group-item">姓名：{{user.name}}</li>
							<li class="list-group-item">邮箱：{{user.email}}</li>
							<li class="list-group-item">用户类型：{{type}}</li>
							<li class="list-group-item">
								<button class="btn btn-primary" @click="logout">登出</button>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Api from '../api'

	export default {
		name: "HomeComponent",
		mounted() {
			if (!localStorage.token) {
				this.$router.push('/login');
				return false;
			}
			this.type = localStorage.user_type;
			console.log(this.type);
			this.getUser();
		},

		data() {
			return {
				type: '',
				user: {},
			};
		},

		methods: {
			getUser() {
				if (this.user_type === 'teacher') {
					Api.teacher()
						.then((result) => {
							this.user = result.data.user;
						})
						.catch((error) => {
							console.log(error.response);
							if (error.response.status === 401) {
								localStorage.setItem('token', '');
								localStorage.setItem('refresh_token', '');
								localStorage.setItem('user_type', '');
								this.$router.push('/login');
							}
						});
				} else {
					Api.student()
						.then((result) => {
							this.user = result.data.user;
						})
						.catch((error) => {
							if (error.response.status === 401) {
								localStorage.setItem('token', '');
								localStorage.setItem('refresh_token', '');
								localStorage.setItem('user_type', '');
								this.$router.push('/login');
							}
						});
				}
			},
			logout() {
				localStorage.clear();
				this.$router.push('/login');
			}
		}
	}
</script>

<style scoped>

</style>
