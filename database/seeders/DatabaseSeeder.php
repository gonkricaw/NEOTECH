<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		if (env('APP_ENV') != 'envato') {
			$this->call(WarehouseTableSeeder::class);
			$this->call(CurrencyTableSeeder::class);
			$this->call(LangTableSeeder::class);
			$this->call(PaymentModesTableSeeder::class);
			$this->call(CompanyTableSeeder::class);
			$this->call(RolesTableSeeder::class);
			$this->call(UsersTableSeeder::class);

			$this->call(BrandsTableSeeder::class);
			$this->call(CategoryTableSeeder::class);
			$this->call(ProductTableSeeder::class);
			$this->call(StockAdjustmentTableSeeder::class);
			$this->call(OrdersTableSeeder::class);
			$this->call(PaymentsTableSeeder::class);
			$this->call(ExpenseTableSeeder::class);

			$this->call(FrontWebsiteSettingsDatabaseSeeder::class);
			$this->call(FrontProductCardDatabaseSeeder::class);
		}
	}
}
