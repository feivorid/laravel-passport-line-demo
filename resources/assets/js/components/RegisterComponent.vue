<template>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">注册</div>
					<div class="panel-body">
						<div class="form-horizontal">
							<input type="hidden" name="_token" value="">
							<div class="form-group">
								<label for="type" class="col-md-4 control-label">用户类型</label>
								<div class="col-md-6">
									<select name="type" required="required" autofocus="autofocus" v-model="type" id=""
													class="form-control">
										<option value="student">学生</option>
										<option value="teacher">老师</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="col-md-4 control-label">姓名</label>
								<div class="col-md-6">
									<input id="name" type="text" v-model="name" name="name" value="" required="required"
												 autofocus="autofocus" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-md-4 control-label">邮箱</label>
								<div class="col-md-6">
									<input id="email" type="email" v-model="email" name="email" value="" required="required"
												 class="form-control"></div>
							</div>
							<div class="form-group"><label for="password" class="col-md-4 control-label">密码</label>
								<div class="col-md-6">
									<input id="password" type="password" name="password" required="required"
												 class="form-control" v-model="password">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="button" @click="register" class="btn btn-primary">
										注册
									</button>
									<router-link class="btn btn-primary pull-right" to="/login">去登录</router-link>
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
		mounted() {
			if (localStorage.token) {
				this.$router.push('/');
			}
		},

		data: () => {
			return {
				type: 'teacher',
				email: '',
				password: '',
				name: '',
			};
		},

		methods: {
			async register() {
				if (!this.type) {
					alert('请选择类型');
					return false;
				}
				if (!this.name) {
					alert('请输入姓名');
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
				let result = await Api.register({
					name: this.name,
					email: this.email,
					password: this.password,
					type: this.type,
				});

				console.log(result);
				if (result.data.code === 200) {
					alert('注册成功');
					await this.$router.push('/login')
				} else {
					alert(result.data.message);
				}
			}
		}
	}

</script>
