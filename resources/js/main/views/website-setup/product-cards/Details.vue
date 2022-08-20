<template>
	<a-drawer
		:title="$t('user.user_details')"
		:width="720"
		:visible="visible"
		:body-style="{ paddingBottom: '80px' }"
		:maskClosable="false"
		@close="onClose"
	>
		<p>sdfs</p>
	</a-drawer>
</template>
<script>
import { defineComponent } from "vue";

export default defineComponent({
	props: ["data", "visible"],
	setup(props, { emit }) {
		const onClose = () => {
			emit("closed");
		};

		return {
			onClose,
		};
	},
});
</script>
