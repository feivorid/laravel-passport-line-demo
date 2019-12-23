<template>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">登录</div>
					<div class="panel-body">
						<div class="form-horizontal">
							<input type="hidden" name="_token" value="">
							<div class="form-group">
								<label for="type" class="col-md-4 control-label">用户类型</label>
								<div class="col-md-6">
									<select name="type" v-model="type" id="" class="form-control">
										<option value="student">学生</option>
										<option value="teacher">老师</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-md-4 control-label">邮箱</label>
								<div class="col-md-6">
									<input id="email" v-model="email" type="email" name="email" value="" required="required"
												 class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-md-4 control-label">密码</label>
								<div class="col-md-6">
									<input id="password" v-model="password" type="password" name="password" required="required"
												 class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary" @click="login">登录</button>
									<button type="button" class="btn btn-primary pull-right">LINE登录</button>
									<router-link class="btn btn-primary pull-right" to="/register">去注册</router-link>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Api from '../api';

	export default {
		name: "LoginComponent",
		mounted() {
			if (localStorage.token) {
				this.$router.push('/');
			}
		},
		data() {
			return {
				type: 'teacher',
				email: '',
				password: '',
			}
		},

		methods: {
			async login() {
				if (!this.type) {
					alert('请选择类型');
					return false;
				}
				if (!this.email) {
					alert('请输入邮箱');
					return false;
				}
				if (!this.password) {
					alert('请输入密码');
					return false;
				}

				let result = await Api.login({
					type: this.type,
					email: this.email,
					password: this.password,
				});

				console.log(result);
				if (result.data.code === 200) {
					console.log(result);
					localStorage.token = result.data.access_token;
					localStorage.refresh_token = result.data.refresh_token;
					console.log(localStorage);
					await this.$router.push('/');
				} else {
					alert(result.data.message);
				}
			}
		}
	}
</script>

<style scoped>

</style>
