<?php

namespace App\Http\Controllers\Api;

use App\Classes\Common;
use App\Classes\LangTrans;
use App\Classes\PermsSeed;
use App\Http\Controllers\ApiBaseController;
use Examyou\RestAPI\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use ZanySoft\Zip\Zip;

class UpdateAppController extends ApiBaseController
{
	public function index()
	{
		$laravel = app();
		$updateVersionInfo['laravelVersion'] = $laravel::VERSION;
		$appVersion = $this->getAppVersion();

		$appDetails = [
			[
				'name' => 'app_details',
				'value' => '',
			],
			[
				'name' => 'app_version',
				'value' => $appVersion,
			],
			[
				'name' => 'php_version',
				'value' => phpversion(),
			],
			[
				'name' => 'laravel_version',
				'value' => $laravel::VERSION,
			],
			[
				'name' => 'vue_version',
				'value' => '',
			],
			[
				'name' => 'mysql_version',
				'value' => mysqli_get_client_info(),
			],
		];

		return ApiResponse::make('Data fetched', [
			'app_details' => $appDetails,
			'app_version' => $appVersion
		]);
	}

	

	public function configClear()
	{
		Artisan::call('config:clear');
		Artisan::call('route:clear');
		Artisan::call('view:clear');
		Artisan::call('cache:clear');
	}


	public function getAppVersion()
	{
		$appVersion = File::get('version.txt');

		return preg_replace("/\r|\n/", "", $appVersion);
	}

	public function downloadPercent(Request $request)
	{
		$percentage = File::get(public_path() . '/download-percentage.txt');

		return ApiResponse::make('Success', [
			'percentage' => $percentage
		]);
	}
}
