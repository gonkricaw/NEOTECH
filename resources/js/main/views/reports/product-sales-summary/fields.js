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
			title: t("product.unit_sold"),
			dataIndex: "unit_sold",
		},
	];

	return {
		columns,
		hashableColumns,
	}
}

export default fields;