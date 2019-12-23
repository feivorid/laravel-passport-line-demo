<template>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">登录</div>
					<div class="panel-body">
						<form method="POST" action="" class="form-horizontal">
							<input type="hidden" name="_token" value="">
							<div class="form-group">
								<label for="type" class="col-md-4 control-label">用户类型</label>
								<div class="col-md-6">
									<select name="type" id="" class="form-control">
										<option value="student">学生</option>
										<option value="teacher">老师</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-md-4 control-label">邮箱</label>
								<div class="col-md-6">
									<input id="email" type="email" name="email" value="" required="required" class="form-control"></div>
							</div>
							<div class="form-group"><label for="password" class="col-md-4 control-label">密码</label>
								<div class="col-md-6"><input id="password" type="password" name="password" required="required"
																						 class="form-control"></div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										登录
									</button>
									<button type="button" class="btn btn-primary pull-right">LINE登录</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "LoginComponent"
	}
</script>

<style scoped>

</style>
