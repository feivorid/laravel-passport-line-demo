<template>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">个人信息</div>
					<div class="panel-body">
						<ul class="list-group">
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

			<student-component v-if="type === 'teacher'" v-bind:follows="students"></student-component>
			<teacher-component v-if="type === 'student'" v-bind:teachers="teachers"></teacher-component>
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
				students: [],
				teachers: [],
			};
		},

		methods: {
			getUser() {
				console.log();
				if (this.type === 'teacher') {
					Api.teacher()
						.then((result) => {
							this.user = result.data.user;
							this.students = result.data.follows;
						})
						.catch((error) => {
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
							this.teachers = result.data.teachers;
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
