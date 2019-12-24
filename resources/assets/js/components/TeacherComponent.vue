<template>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">老师列表</div>
			<div class="panel-body">
				<ul class="list-group">
					<li v-for="teacher in teachers" class="list-group-item">
						{{teacher.name || '无名氏'}}
						<button class="btn btn-primary btn-xs pull-right" @click="follow(teacher.id, teacher.followed)">
							{{teacher.followed ? '取消关注' : '关注'}}
						</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
	import Api from '../api';

	export default {
		mounted() {
		},
		name: "TeacherComponent",
		props: {
			teachers: Array,
		},
		data: () => {
			return {
				teachers: this.teachers,
			};
		},
		methods: {
			follow(id, followed) {
				Api.follow({
					teacher_id: id,
					status: followed ? 0 : 1,
				}).then((result) => {
					if (result.status === 200) {
						alert('操作成功');
					}
				}).catch((error) => {
					if (error.response.status === 400) {
						alert(error.data.message);
					}
				})
			}
		}
	}
</script>

<style scoped>

</style>
