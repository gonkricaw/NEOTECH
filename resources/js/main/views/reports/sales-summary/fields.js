import { useI18n } from "vue-i18n";

const fields = () => {
	const { t } = useI18n();
	const orderHashableColumns = ['staff_user_id'];

	const salesSummaryColumns = [
		{
			title: t("stock.order_date"),
			dataIndex: "order_date",
		},
		{
			title: t("stock.invoice_number"),
			dataIndex: "invoice_number",
		},
		{
			title: t("common.party"),
			dataIndex: "user_id",
		},
		{
			title: t("payments.amount"),
			dataIndex: "amount",
		},
		{
			title: t("payments.payment_status"),
			dataIndex: "payment_status",
		},
		{
			title: t("common.created_by"),
			dataIndex: "staff_user_id",
		},
	];

	return {
		salesSummaryColumns,
		orderHashableColumns,
	}
}

export default fields;