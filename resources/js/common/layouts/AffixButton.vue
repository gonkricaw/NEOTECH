<template>
	<a-affix
		:offset-bottom="innerWidth <= 991 ? 80 : 40"
		:style="{ textAlign: 'right', marginRight: '20px' }"
	>
		<a-dropdown placement="topRight">
			<a-button
				type="primary"
				shape="circle"
				:style="{ width: '50px', height: '50px' }"
			>
				<template #icon><PlusOutlined /></template>
			</a-button>
			<template #overlay>
				<a-menu>
					<a-menu-item
						v-if="
							permsArray.includes('customers_view') ||
							permsArray.includes('admin')
						"
						@click="
							() => {
								menuSelected();
								$router.push({
									name: 'admin.customers.index',
								});
							}
						"
						key="customers"
					>
						<TeamOutlined />
						{{ $t("menu.customers") }}
					</a-menu-item>
					<a-menu-item
						v-if="
							permsArray.includes('suppliers_view') ||
							permsArray.includes('admin')
						"
						@click="
							() => {
								menuSelected();
								$router.push({
									name: 'admin.suppliers.index',
								});
							}
						"
						key="suppliers"
					>
						<TeamOutlined />
						{{ $t("menu.suppliers") }}
					</a-menu-item>
					<a-menu-item
						@click="
							() => {
								menuSelected();
								$router.push({
									name: 'admin.products.index',
								});
							}
						"
						key="products"
						v-if="
							permsArray.includes('products_view') ||
							permsArray.includes('admin')
						"
					>
						<AppstoreOutlined />
						{{ $t("menu.products") }}
					</a-menu-item>
					<a-menu-item
						@click="
							() => {
								menuSelected();
								$router.push({
									name: 'admin.stock.sales.index',
								});
							}
						"
						key="sales"
						v-if="
							permsArray.includes('sales_view') ||
							permsArray.includes('admin')
						"
					>
						<ShopOutlined />
						{{ $t("menu.sales") }}
					</a-menu-item>
					<a-menu-item
						@click="
							() => {
								menuSelected();
								$router.push({
									name: 'admin.stock.purchases.index',
								});
							}
						"
						key="purchases"
						v-if="
							permsArray.includes('purchases_view') ||
							permsArray.includes('admin')
						"
					>
						<ShoppingOutlined />
						{{ $t("menu.purchases") }}
					</a-menu-item>
				</a-menu>
			</template>
		</a-dropdown>
	</a-affix>
</template>

<script>
import {
	PlusOutlined,
	TeamOutlined,
	AppstoreOutlined,
	ShopOutlined,
	ShoppingOutlined,
} from "@ant-design/icons-vue";
import common from "../composable/common";

export default {
	components: {
		PlusOutlined,
		TeamOutlined,
		AppstoreOutlined,
		ShopOutlined,
		ShoppingOutlined,
	},
	setup() {
		const { permsArray } = common();

		const menuSelected = () => {};

		return {
			permsArray,
			menuSelected,

			innerWidth: window.innerWidth,
		};
	},
};
</script>
