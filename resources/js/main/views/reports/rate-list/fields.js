import { useI18n } from "vue-i18n";

const fields = () => {
	const { t } = useI18n();
	const hashableColumns = ['product_id'];

	const columns = [
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
			title: t("product.mrp"),
			dataIndex: "mrp",
		},
		{
			title: t("product.sales_price"),
			dataIndex: "sales_price",
		},
	];

	return {
		columns,
		hashableColumns,
	}
}

export default fields;