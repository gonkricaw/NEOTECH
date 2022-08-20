<?php

use App\Models\FrontWebsiteSettings;
use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateFrontWebsiteSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('front_website_settings', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('warehouse_id')->unsigned()->nullable()->default(null);
			$table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade')->onUpdate('cascade');
			$table->json('featured_categories');
			$table->string('featured_categories_title')->nullable()->default('Featured Categories');
			$table->string('featured_categories_subtitle')->nullable()->default('');
			$table->json('featured_products');
			$table->string('featured_products_title')->nullable()->default('Featured Products');
			$table->string('featured_products_subtitle')->nullable()->default('');

			$table->json('features_lists');

			//Social 
			$table->string('facebook_url')->nullable()->default('');
			$table->string('twitter_url')->nullable()->default('');
			$table->string('instagram_url')->nullable()->default('');
			$table->string('linkedin_url')->nullable()->default('');
			$table->string('youtube_url')->nullable()->default('');

			$table->json('pages_widget');
			$table->json('contact_info_widget');
			$table->json('links_widget');

			$table->string('footer_company_description', 1000)->default("Stockify have many propular products wiht high discount and special offers.");
			$table->string('footer_copyright_text', 1000)->default("Copyright 2021 @ Stockify, All rights reserved.");

			$table->json('top_banners');
			$table->json('bottom_banners_1');
			$table->json('bottom_banners_2');
			$table->json('bottom_banners_3');

			$table->timestamps();
		});

		// Adding slug column in warehouses table
		Schema::table('warehouses', function (Blueprint $table) {
			$table->string('slug')->nullable()->default(null)->after('name');
			$table->string('dark_logo')->nullable()->default(NULL)->after('logo');
		});

		$allWarehouses = Warehouse::all();
		foreach ($allWarehouses as $allWarehouse) {

			// Adding slug to warehouse for online store
			$allWarehouse->slug = Str::slug($allWarehouse->name, '-');
			$allWarehouse->save();

			$frontSetting = new FrontWebsiteSettings();
			$frontSetting->warehouse_id = $allWarehouse->id;
			$frontSetting->featured_categories = [];
			$frontSetting->featured_products = [];
			$frontSetting->features_lists = [];
			$frontSetting->pages_widget = [];
			$frontSetting->contact_info_widget = [];
			$frontSetting->links_widget = [];
			$frontSetting->top_banners = [];
			$frontSetting->bottom_banners_1 = [];
			$frontSetting->bottom_banners_2 = [];
			$frontSetting->bottom_banners_3 = [];
			$frontSetting->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('front_website_settings');

		Schema::table('warehouses', function (Blueprint $table) {
			$table->dropColumn('slug');
			$table->dropColumn('dark_logo');
		});
	}
}
