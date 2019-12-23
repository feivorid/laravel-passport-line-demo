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
						</ul>
						<ul class="list-group col-md-6">
							<li class="list-group-item"></li>
							<li class="list-group-item"></li>
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
			this.type = localStorage.user_type;
			this.getUser();
		},

		data() {
			return {
				type: '',
				user: {},
			};
		},

		methods: {
			async getUser() {
				if (this.user_type === 'teacher') {
					let result = await Api.teacher();
					this.user = result.data.user;
				} else {
					let result = await Api.student();
					this.user = result.data.user;
				}
			}
		}
	}
</script>

<style scoped>

</style>
