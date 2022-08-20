<?php

namespace App\Models;

use App\Casts\Hash;
use App\Classes\Common;
use App\Models\BaseModel;

class Order extends BaseModel
{
	protected $table = 'orders';

	protected $default = ['xid'];

	protected $guarded = ['id', 'warehouse_id', 'staff_user_id', 'order_type', 'created_at', 'updated_at'];

	protected $hidden = ['id', 'warehouse_id', 'user_id', 'tax_id', 'staff_user_id', 'cancelled_by'];

	protected $appends = ['xid', 'x_warehouse_id', 'x_user_id', 'x_tax_id', 'x_staff_user_id', 'x_cancelled_by', 'document_url'];

	protected $dates = ['order_date'];

	protected $filterable = ['id', 'invoice_number', 'payment_status', 'order_status', 'cancelled', 'order_date', 'user_id', 'staff_user_id'];

	protected $hashableGetterFunctions = [
		'getXWarehouseIdAttribute' => 'warehouse_id',
		'getXUserIdAttribute' => 'user_id',
		'getXTaxIdAttribute' => 'tax_id',
		'getXStaffUserIdAttribute' => 'staff_user_id',
		'getXCancelledByAttribute' => 'cancelled_by',
	];

	protected $casts = [
		'warehouse_id' => Hash::class . ':hash',
		'user_id' => Hash::class . ':hash',
		'tax_id' => Hash::class . ':hash',
		'cancelled_by' => Hash::class . ':hash',
		'cancelled' => 'integer',
		'is_deletable' => 'integer',
	];

	public function getDocumentUrlAttribute()
	{
		$orderDocumentPath = Common::getFolderPath('orderDocumentPath');

		return $this->image == null ? asset('images/order.png') : Common::getFileUrl($orderDocumentPath, $this->image);
	}

	public function items()
	{
		return $this->hasMany(OrderItem::class, 'order_id', 'id');
	}

	public function orderPayments()
	{
		return $this->hasMany(OrderPayment::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id')->withoutGlobalScope('type');
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class, 'user_id', 'id');
	}

	public function staffMember()
	{
		return $this->belongsTo(User::class, 'staff_user_id', 'id');
	}

	public function warehouse()
	{
		return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
	}

	public function tax()
	{
		return $this->belongsTo(Tax::class, 'tax_id', 'id');
	}

	public function shippingAddress()
	{
		return $this->belongsTo(OrderShippingAddress::class, 'id', 'order_id');
	}
}
