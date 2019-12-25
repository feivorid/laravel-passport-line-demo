<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				@if ($type == 'new')
					<div class="panel-heading">新用户请选择用户类型</div>
					<div class="panel-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="name" class="col-md-4 control-label">类型</label>
								<div class="col-md-6">
									<select class="form-control">
										<option value="teacher">老师</option>
										<option value="student">学生</option>
									</select>
								</div>
								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary">
											登录
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				@else
					<div class="panel-heading">系统检测到该LINE账号有以下关联账户</div>
					<div class="panel-body">
						@if($teacher)
							<ul class="list-group">
								<li class="list-group-item">姓名：{{$teacher->name}}</li>
								<li class="list-group-item">类型：老师</li>
								<li class="list-group-item">
									<button class="btn btn-primary">登录</button>
								</li>
							</ul>
						@endif
						@if ($students)
							@foreach ($students as $student)
								<ul class="list-group">
									<li class="list-group-item">姓名：{{$student->name}}</li>
									<li class="list-group-item">类型：学生</li>
									<li class="list-group-item">
										<button class="btn btn-primary">登录</button>
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

<script src="/js/bootstrap.js"></script>
