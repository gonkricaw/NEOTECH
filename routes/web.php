<?php

use App\Classes\Common;
use App\Models\Company;
use Illuminate\Support\Facades\Route;
use Examyou\RestAPI\Facades\ApiRoute;
use Illuminate\Support\Facades\File;

// Front Store/Warehouse Routes
ApiRoute::group(['prefix' => 'front', 'namespace' => 'App\Http\Controllers\Api\Front'], function () {
	ApiRoute::get('app/{warehouse}', ['as' => 'api.front.app', 'uses' => 'HomePageController@app']);
	ApiRoute::get('homepage/{warehouse}', ['as' => 'api.front.homepage', 'uses' => 'HomePageController@homepage']);
	ApiRoute::post('categories', ['as' => 'api.front.categories', 'uses' => 'HomePageController@categories']);
	ApiRoute::post('category-by-slug/{slug}', ['as' => 'api.front.category-by-slug', 'uses' => 'HomePageController@categoryBySlug']);

	ApiRoute::post('login', ['as' => 'api.front.login', 'uses' => 'HomePageController@login']);
	ApiRoute::post('signup', ['as' => 'api.front.signup', 'uses' => 'HomePageController@signup']);
	ApiRoute::post('refresh-token', ['as' => 'api.front.refresh-token', 'uses' => 'HomePageController@refreshToken']);
	ApiRoute::post('logout', ['as' => 'api.front.logout', 'uses' => 'HomePageController@logout']);

	ApiRoute::group(['middleware' => ['api.front.check']], function () {
		ApiRoute::post('profile', ['as' => 'api.front.profile', 'uses' => 'HomePageController@profile']);
		ApiRoute::post('user', ['as' => 'api.front.user', 'uses' => 'HomePageController@user']);
		ApiRoute::post('upload-file', ['as' => 'api.front.upload-file', 'uses' => 'HomePageController@uploadFile']);

		ApiRoute::group(['prefix' => 'self'], function () {
			// Dashboard Routes
			ApiRoute::post('dashboard', ['as' => 'api.front.self.dashboard', 'uses' => 'DashboardController@dashboard']);
			ApiRoute::post('orders', ['as' => 'api.front.self.orders', 'uses' => 'DashboardController@orders']);
			ApiRoute::post('checkout-orders/{warehouse}', ['as' => 'api.front.self.checkout-orders', 'uses' => 'DashboardController@checkoutOrders']);
			ApiRoute::post('checkout-success/{orderUniqueId}', ['as' => 'api.front.self.checkout-success', 'uses' => 'DashboardController@checkoutSuccess']);
			ApiRoute::post('cancel-order/{orderUniqueId}', ['as' => 'api.front.self.cancel-order', 'uses' => 'DashboardController@cancelOrder']);


			ApiRoute::resource('address', 'UserAddressController', ['as' => 'api.front']);
		});
	});
});

// Admin Routes
ApiRoute::group(['namespace' => 'App\Http\Controllers\Api'], function () {

	ApiRoute::get('app', ['as' => 'api.extra.app', 'uses' => 'AuthController@app']);
	ApiRoute::get('all-langs', ['as' => 'api.extra.all-langs', 'uses' => 'AuthController@allEnabledLangs']);
	ApiRoute::get('pdf/{uniqueId}/{lang?}', ['as' => 'api.extra.pdf', 'uses' => 'AuthController@pdf']);
	ApiRoute::get('lang-trans', ['as' => 'api.extra.lang-trans', 'uses' => 'AuthController@langTrans']);
	ApiRoute::post('change-theme-mode', ['as' => 'api.extra.change-theme-mode', 'uses' => 'AuthController@changeThemeMode']);

	// Public Routes For Front
	ApiRoute::get('products/{product}', ['as' => 'api.products.show', 'uses' => 'ProductController@show']);
	ApiRoute::get('products', ['as' => 'api.products.index', 'uses' => 'ProductController@index']);
	ApiRoute::get('categories/{category}', ['as' => 'api.categories.show', 'uses' => 'CategoryController@show']);
	ApiRoute::get('categories', ['as' => 'api.categories.index', 'uses' => 'CategoryController@index']);
	ApiRoute::get('warehouses', ['as' => 'api.warehouses.index', 'uses' => 'WarehouseController@index']);

	// Authentication routes
	ApiRoute::group(['prefix' => 'auth'], function () {
		ApiRoute::post('login', ['as' => 'api.extra.login', 'uses' => 'AuthController@login']);
		ApiRoute::post('refresh-token', ['as' => 'api.extra.refresh-token', 'uses' => 'AuthController@refreshToken']);
		ApiRoute::post('logout', ['as' => 'api.extra.logout', 'uses' => 'AuthController@logout']);
	});

	ApiRoute::group(['middleware' => ['api.auth.check']], function () {
		ApiRoute::post('dashboard', ['as' => 'api.extra.dashboard', 'uses' => 'AuthController@dashboard']);
		ApiRoute::post('upload-file', ['as' => 'api.extra.upload-file', 'uses' => 'AuthController@uploadFile']);
		ApiRoute::post('profile', ['as' => 'api.extra.profile', 'uses' => 'AuthController@profile']);
		ApiRoute::post('user', ['as' => 'api.extra.user', 'uses' => 'AuthController@user']);
		ApiRoute::get('timezones', ['as' => 'api.extra.user', 'uses' => 'AuthController@getAllTimezones']);
		ApiRoute::post('change-warehouse', ['as' => 'api.extra.change-warehouse', 'uses' => 'AuthController@changeAdminWarehouse']);
		ApiRoute::post('search-product', ['as' => 'api.extra.search-product', 'uses' => 'ProductController@searchProduct']);
	});

	// Routes Accessable to thouse user who have permissions realted to route
	ApiRoute::group(['middleware' => ['api.permission.check', 'api.auth.check']], function () {
		$options = [
			'as' => 'api'
		];

		// Routes for Front Warehouse/Store
		// Routes Accessable to thouse user who have permissions realted to route
		ApiRoute::resource('product-cards', 'FrontProductCardsController', $options);
		ApiRoute::resource('front-settings', 'FrontWebsiteSettingsController', ['as' => 'api', 'only' => ['index', 'update']]);
		ApiRoute::post('product-lists/search-products', ['as' => 'api.extra.product-cards.search-products', 'uses' => 'FrontProductCardsController@searchProducts']);
		ApiRoute::post('online-orders/delivered/{id}', ['as' => 'api.online-orders.delivered', 'uses' => 'OnlineOrdersController@markAsDelivered']);
		ApiRoute::post('online-orders/change-status/{id}', ['as' => 'api.online-orders.change-status', 'uses' => 'OnlineOrdersController@changeOrderStatus']);
		ApiRoute::post('online-orders/confirm/{id}', ['as' => 'api.online-orders.confirm', 'uses' => 'OnlineOrdersController@confirmOrder']);
		ApiRoute::post('online-orders/cancel/{id}', ['as' => 'api.online-orders.cancel', 'uses' => 'OnlineOrdersController@cancelOrder']);
		ApiRoute::resource('online-orders', 'OnlineOrdersController', ['as' => 'api', 'only' => ['index']]);

		//POS
		ApiRoute::post('pos/products', ['as' => 'api.pos.products', 'uses' => 'PosController@posProducts']);
		ApiRoute::post('pos/save', ['as' => 'api.pos.save', 'uses' => 'PosController@savePosPayments']);
		ApiRoute::post('product-warehouse-stock', ['as' => 'api.products.product-warehouse-stock', 'uses' => 'ProductController@getWarehouseStock']);

		ApiRoute::get('stock-alerts', ['as' => 'api.orders.items', 'uses' => 'AuthController@stockAlerts']);

		ApiRoute::post('translations/refetch', ['as' => 'api.translations.refetch', 'uses' => 'TranslationsController@refetchTranslations']);
		ApiRoute::resource('translations', 'TranslationsController', ['as' => 'api', 'only' => ['update']]);

		ApiRoute::post('user-invoices', ['as' => 'api.payments.user-invoices', 'uses' => 'PaymentController@userInvoices']);
		ApiRoute::post('customer-suppliers', ['as' => 'api.payments.customer-suppliers', 'uses' => 'PaymentController@customerSuppliers']);
		ApiRoute::resource('payments', 'PaymentInController', ['as' => 'api', 'only' => ['index']]);

		// Imports
		ApiRoute::post('brands/import', ['as' => 'api.brands.import', 'uses' => 'BrandController@import']);
		ApiRoute::post('categories/import', ['as' => 'api.categories.import', 'uses' => 'CategoryController@import']);
		ApiRoute::post('products/import', ['as' => 'api.products.import', 'uses' => 'ProductController@import']);
		ApiRoute::post('customers/import', ['as' => 'api.customers.import', 'uses' => 'CustomersController@import']);
		ApiRoute::post('suppliers/import', ['as' => 'api.suppliers.import', 'uses' => 'SuppliersController@import']);
		ApiRoute::post('users/import', ['as' => 'api.users.import', 'uses' => 'UsersController@import']);

		// Payments
		ApiRoute::resource('payment-out', 'PaymentOutController', $options);
		ApiRoute::resource('payment-in', 'PaymentInController', $options);

		ApiRoute::resource('brands', 'BrandController', $options);
		ApiRoute::resource('categories', 'CategoryController', ['as' => 'api', 'except' => ['index', 'show']]);
		ApiRoute::resource('products', 'ProductController', ['as' => 'api', 'except' => ['index']]);
		ApiRoute::resource('order-payments', 'OrderPaymentController', ['as' => 'api', 'only' => ['index', 'store']]);
		ApiRoute::resource('payment-modes', 'PaymentModeController', $options);
		ApiRoute::resource('units', 'UnitController', $options);
		ApiRoute::resource('taxes', 'TaxController', $options);
		ApiRoute::resource('langs', 'LangsController', $options);
		ApiRoute::resource('expenses', 'ExpenseController', $options);
		ApiRoute::resource('expense-categories', 'ExpenseCategoryController', $options);
		ApiRoute::resource('currencies', 'CurrencyController', $options);
		ApiRoute::resource('users', 'UsersController', $options);
		ApiRoute::resource('customers', 'CustomersController', $options);
		ApiRoute::resource('suppliers', 'SuppliersController', $options);
		ApiRoute::resource('companies', 'CompanyController', ['as' => 'api', 'only' => ['update']]);
		ApiRoute::resource('permissions', 'PermissionController', ['as' => 'api', 'only' => ['index']]);
		ApiRoute::resource('warehouse-history', 'WarehouseHistoryController', ['as' => 'api', 'only' => ['index']]);
		ApiRoute::resource('stock-history', 'StockHistoryController', ['as' => 'api', 'only' => ['index']]);
		ApiRoute::resource('order-items', 'OrderItemController', ['as' => 'api', 'only' => ['index']]);
		ApiRoute::resource('roles', 'RolesController', $options);
		ApiRoute::resource('warehouses', 'WarehouseController',  ['as' => 'api', 'except' => ['index']]);
		ApiRoute::resource('custom-fields', 'CustomFieldController', $options);
		ApiRoute::resource('stock-adjustments', 'StockAdjustmentController', $options);
		ApiRoute::resource('purchases', 'PurchaseController', $options);
		ApiRoute::resource('purchase-returns', 'PurchaseReturnsController', $options);
		ApiRoute::resource('sales', 'SalesController', $options);
		ApiRoute::resource('sales-returns', 'SalesReturnsController', $options);


		ApiRoute::group(['prefix' => 'settings'], function () {
			ApiRoute::post('storage/update', ['as' => 'api.settings.storage.update', 'uses' => 'SettingsController@updateStorage']);
			ApiRoute::get('storage', ['as' => 'api.settings.storage.index', 'uses' => 'SettingsController@getStorage']);
			ApiRoute::post('email/send-test-mail', ['as' => 'api.settings.email.send-test-mail', 'uses' => 'SettingsController@sendTestMail']);
			ApiRoute::post('email/send-mail-settings', ['as' => 'api.settings.send-mail-settings', 'uses' => 'SettingsController@sendMailSettings']);
			ApiRoute::post('email/update', ['as' => 'api.settings.email.update', 'uses' => 'SettingsController@updateEmailSetting']);
			ApiRoute::get('email', ['as' => 'api.settings.email.index', 'uses' => 'SettingsController@getEmailSetting']);
		});

		ApiRoute::post('modules/extract', ['as' => 'api.modules.extract', 'uses' => 'ModuleController@extractZip']);
		ApiRoute::get('modules/download-percentage', ['as' => 'api.modules.download-percentage', 'uses' => 'ModuleController@downloadPercent']);
		ApiRoute::post('modules/install', ['as' => 'api.modules.install', 'uses' => 'ModuleController@install']);
		ApiRoute::post('modules/update-status', ['as' => 'api.modules.update_status', 'uses' => 'ModuleController@updateStatus']);
		ApiRoute::get('modules', ['as' => 'api.modules.index', 'uses' => 'ModuleController@index']);

		ApiRoute::get('update-app/download-percentage', ['as' => 'api.update-app.download-percentage', 'uses' => 'UpdateAppController@downloadPercent']);
		ApiRoute::post('update-app/extract', ['as' => 'api.update-app.extract', 'uses' => 'UpdateAppController@extractZip']);
		ApiRoute::post('update-app/update', ['as' => 'api.update-app.update', 'uses' => 'UpdateAppController@updateApp']);
		ApiRoute::get('update-app', ['as' => 'api.update-app.index', 'uses' => 'UpdateAppController@index']);
	});
});

Route::get('{path}', function () {
	if (file_exists(storage_path('installed'))) {
		$appName = "Stockifly";
		$appVersion = File::get(public_path() . '/version.txt');
		$modulesData = Common::moduleInformations();
		$themeMode = session()->has('theme_mode') ? session('theme_mode') : 'light';
		$company = Company::first();
		$appVersion = File::get('version.txt');
		$appVersion = preg_replace("/\r|\n/", "", $appVersion);

		return view('welcome', [
			'appName' => $appName,
			'appVersion' => preg_replace("/\r|\n/", "", $appVersion),
			'installedModules' => $modulesData['installed_modules'],
			'enabledModules' => $modulesData['enabled_modules'],
			'themeMode' => $themeMode,
			'company' => $company,
			'appVersion' => $appVersion,
			'appEnv' => env('APP_ENV'),
		]);
	} else {
		return redirect('/install');
	}
})->where('path', '^(?!api.*$).*');
