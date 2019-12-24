<template>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">关注我的学生</div>
			<div class="panel-body">
				<ul class="list-group">
					<li v-for="follow in follows" class="list-group-item">{{follow.student ? follow.student.name : '无名氏'}}</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		mounted() {
			console.log(this.follows);
		},
		name: "StudentComponent",
		props: {
			follows: Array,
		},

		methods: {}
	}
</script>

<style scoped>


</style>
