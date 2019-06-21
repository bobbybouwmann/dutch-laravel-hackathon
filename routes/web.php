<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Services\ForgeExtractor;
use App\Services\LaracastsScraper;
use App\Services\LaravelCertificateValidationService;
use App\Services\PackagistExtractor;

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('profile/{user}', 'ProfileController@show')->name('profile.show');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::patch('profile/edit', 'ProfileController@update')->name('profile.update');
});

Route::get('/cert', function () {
    $laravelCertificationInfo = new LaravelCertificateValidationService('Bobby Bouwmann', '2018-01-26');

    echo $laravelCertificationInfo->isValid();
});

Route::get('/packagist/{vendorName}', function (PackagistExtractor $packagistExtractor, string $vendorName) {
    dd($packagistExtractor->getStatsForVendor($vendorName));
});

Route::get('/laracasts/{username}', function (LaracastsScraper $scraper, string $username) {
    return $scraper->getDataFor($username)->statistics();
});

Route::get('/forge', function (ForgeExtractor $forgeExtractor) {
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjdiMTY4MTk3YjNjZDZmZjI2MGYwODVjOTBhNmRiNmExMmM3ZWE2OTMyYWU4YTgxYWQ5Y2I0Y2E1NTcwYWZlZDhlZTg0OTdjZjgxY2JiNDhhIn0.eyJhdWQiOiIxIiwianRpIjoiN2IxNjgxOTdiM2NkNmZmMjYwZjA4NWM5MGE2ZGI2YTEyYzdlYTY5MzJhZThhODFhZDljYjRjYTU1NzBhZmVkOGVlODQ5N2NmODFjYmI0OGEiLCJpYXQiOjE1NjExMjYwMjYsIm5iZiI6MTU2MTEyNjAyNiwiZXhwIjoxODc2NzQ1MjI2LCJzdWIiOiIxMTY0OSIsInNjb3BlcyI6W119.klFif1XJWi24aw7X2G4dMVNnvbeqylmyzhtPwiD9sS8bOUBOA9EZw_vME9-zl_isFBn4jquQVZ-xvok7YeEF4vRWFSlejhtU-dkox32YeKcAKTYyp0s7R-VNWyf5zW1lZea9AQa8RwmERjquLU-l8LzmquzTymqZNpfgz0KwhGWcCYq-aIemZ2sPqSrBGOs9Smf6ZTIFvu6d378m23oJQoAfZewjaUIA_RCl3GI1fClzGU8gsf-pM-FVV7iIvcSLFLYXW76FiZlSZkCyRRzQVYkVS78d2xd-C-Kmxvcdwy1ZgNNyL920hiHn45arYXMGhdwP8ggIPiWNRMlWv0ni_PCDfcCEY26ZkMbZK9SCODiwn-pUtzjN8wx3npOl-YLdICLlqcfF1Ulrm4ft-40ETFJ9asffIOi_Lv2A4cH1L7UAUpZnkpTUXIpY1ANTnSHcsRtt99o6KJCtcfKNis69SFZOxW61ncbeju4NCftWQppdMWMoPtbDzdC1Ri1Ge8RcidyPBfSHoW5l1iSl6Lq5zIHCX7kG7C5UCxYuRxPLby1lTd6JnqcRBL4ABHP0O9u43lRsc-9w90sf494BN6g0zbGUG-eOBsJgKHATNyXrpyLKDw8km-fNAe6bXZvF-iVroT-cuDTlcFiSnpPWx7NlXXrcoQP2xLu_wvrbQ78u1hE';
    dd($forgeExtractor->getStatsForApiKey($token));
});

