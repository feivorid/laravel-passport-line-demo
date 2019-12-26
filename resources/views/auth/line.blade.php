<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LINE登录</title>
	<link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div class="container">
	<div class="row" id="line">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				@if ($type == 'new')
					<div class="panel-heading">新用户请选择用户类型</div>
					<div class="panel-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="name" class="col-md-4 control-label">类型</label>
								<div class="col-md-6">
									<select v-model="type" class="form-control">
										<option value="teacher">老师</option>
										<option value="student">学生</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-4">
									<button class="btn btn-primary" @click="loginAsNewUser()">登录</button>
								</div>
							</div>
						</div>
					</div>
				@else
					<div class="panel-heading">系统检测到该LINE账号有以下关联账户</div>
					<div class="panel-body">
						@if($teacher)
							<ul class="list-group col-md-6">
								<li class="list-group-item">姓名：{{$teacher->name}}</li>
								<li class="list-group-item">类型：teacher</li>
								<li class="list-group-item">
									<button class="btn btn-primary" @click="loginAsOldUser({{$teacher->id}}, 'teacher')">登录</button>
								</li>
							</ul>
						@endif
						@if ($students)
							@foreach ($students as $student)
								<ul class="list-group col-md-6">
									<li class="list-group-item">姓名：{{$student->name}}</li>
									<li class="list-group-item">类型：student</li>
									<li class="list-group-item">
										<button class="btn btn-primary" @click="loginAsOldUser({{$student->id}}, 'student')">登录</button>
									</li>
								</ul>
							@endforeach
						@endif
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
</body>
<script src="/js/app.js"></script>
<script>
	var vm = new Vue({
		el: "#line",
		data: {
			type: 'teacher',
			line_id: '{{$line->line_id}}',
		},
		methods: {
			loginAsOldUser(id, type) {
				axios.post('https://laravel-passport-demo.herokuapp.com/api/login/line/old', {
					id: id,
					type: type,
				}).then((result) => {
					if (result.status === 200) {
						localStorage.setItem('token', result.data.access_token);
						localStorage.setItem('refresh_token', result.data.refresh_token);
						localStorage.setItem('user_type', type);
						window.location.href = '/';
					}
				}).catch((error) => {
					console.log(error.response);
				});
			},

			loginAsNewUser() {
				console.log(this.line_id);
				console.log(this.type);

				axios.post('https://laravel-passport-demo.herokuapp.com/api/login/line/new', {
					type: this.type,
					line_id: this.line_id,
				}).then((result) => {
					if (result.status === 200) {
						localStorage.setItem('token', result.data.access_token);
						localStorage.setItem('refresh_token', result.data.refresh_token);
						localStorage.setItem('user_type', this.type);
						window.location.href = '/';
					}
				}).catch((error) => {
					if (error.status === 400) {
						alert(error.data.message);
					}
				});
			}
		}
	});
</script>
</html>
