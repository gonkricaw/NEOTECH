import { useI18n } from "vue-i18n";

const fields = () => {
	const { t } = useI18n();
	const hashableColumns = ['category_id', 'brand_id'];

	const summaryColumns = [
		{
			title: t("product.product"),
			dataIndex: "name",
		},
		{
			title: t("product.item_code"),
			dataIndex: "item_code",
		},
		{
			title: t("product.category"),
			dataIndex: "category_id",
		},
		{
			title: t("product.brand"),
			dataIndex: "brand_id",
		},
		{
			title: t("product.purchase_price"),
			dataIndex: "purchase_price",
		},
		{
			title: t("product.sales_price"),
			dataIndex: "sales_price",
		},
		{
			title: t("product.current_stock"),
			dataIndex: "current_stock",
		},
		{
			title: t("product.stock_value"),
			dataIndex: "stock_value",
		},
	];

	return {
		hashableColumns,
		summaryColumns,
	}
}

export default fields;