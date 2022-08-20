<template>
	<div class="loading-app-container">
		<a-result>
			<template #title>
				<!-- <span class="loading-text" :style="{ color: '#7676e3' }">
					Welcome Neotech Application <br>
					... Please Wait ...
				</span> -->
				<h1 class="h1-loading">
					<span class="span-loading">L</span>
					<span class="span-loading">o</span>
					<span class="span-loading">a</span>
					<span class="span-loading">d</span>
					<span class="span-loading">i</span>
					<span class="span-loading">n</span>
					<span class="span-loading">g</span>
				</h1>
			</template>
			<template #icon>
				<img style="width: 150px" :src="appSetting.light_logo_url" />
			</template>
			<template #extra>
				<SyncOutlined :style="{ fontSize: '38px', color: '#5254cf' }" spin />
			</template>
		</a-result>
	</div>
</template>

<script>
import { defineComponent } from "vue";
import { SyncOutlined } from "@ant-design/icons-vue";
import common from "../../common/composable/common";

export default defineComponent({
	components: {
		SyncOutlined,
	},
	setup() {
		const { appSetting } = common();

		return {
			appSetting,
		};
	},
});
</script>

<style lang="less" scoped>
@import url('https://fonts.googleapis.com/css2?family=Russo+One&display=swap');
.loading-app-container {
	height: 100%;
	width: 100%;
	display: flex;
	position: fixed;
	align-items: top;
	justify-content: center;
	background: #f8f8ff;
}

.loading-text {
	font-family: 'Russo One', sans-serif;
	font-size: 28px;
}

@import url("https://fonts.googleapis.com/css?family=Luckiest+Guy");

.h1-loading {
	cursor: default;
	position: absolute;
	font-family: 'Luckiest Guy', cursive;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	height: 100px;
	margin: auto;
	display: block;
	text-align: center;
	color: '#7676e3';
	
}

.h1-loading .span-loading {
	position: relative;
	top: 20px;
	display: inline-block;
	-webkit-animation: bounce 0.3s ease infinite alternate;
	font-size: 80px;
	color: #fff;
	text-shadow: 0 1px 0 #ccc, 0 2px 0 #ccc, 0 3px 0 #ccc, 0 4px 0 #ccc,
		0 5px 0 #ccc, 0 6px 0 transparent, 0 7px 0 transparent, 0 8px 0 transparent,
		0 9px 0 transparent, 0 10px 10px rgba(0, 0, 0, 0.4);
}

.h1-loading .span-loading:nth-child(2) {
	-webkit-animation-delay: 0.1s;
}

.h1-loading .span-loading:nth-child(3) {
	-webkit-animation-delay: 0.2s;
}

.h1-loading .span-loading:nth-child(4) {
	-webkit-animation-delay: 0.3s;
}

.h1-loading .span-loading:nth-child(5) {
	-webkit-animation-delay: 0.4s;
}

.h1-loading .span-loading:nth-child(6) {
	-webkit-animation-delay: 0.5s;
}

/* ANIMATION */
@-webkit-keyframes bounce {
	100% {
		top: -20px;
		text-shadow: 0 1px 0 #ccc, 0 2px 0 #ccc, 0 3px 0 #ccc, 0 4px 0 #ccc,
			0 5px 0 #ccc, 0 6px 0 #ccc, 0 7px 0 #ccc, 0 8px 0 #ccc, 0 9px 0 #ccc,
			0 50px 25px rgba(0, 0, 0, 0.2);
	}
}
</style>
