<?php

namespace App\Http\Controllers\Api;

use App\Helpers\BakerySettings;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\HomepageOffer;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class CmsController extends Controller
{
    public function settings(): JsonResponse
    {
        $data = Cache::remember('api.cms.settings', 1800, fn () => BakerySettings::all());

        return response()->json(['data' => $data])->header('Cache-Control', 'public, max-age=600');
    }

    public function faqs(): JsonResponse
    {
        $data = Cache::remember('api.cms.faqs', 1800, fn () => Faq::active()->get());

        return response()->json(['data' => $data])->header('Cache-Control', 'public, max-age=600');
    }

    public function gallery(): JsonResponse
    {
        $data = Cache::remember('api.cms.gallery', 1800, fn () => GalleryItem::active()->get());

        return response()->json(['data' => $data])->header('Cache-Control', 'public, max-age=600');
    }

    public function offers(): JsonResponse
    {
        $data = Cache::remember('api.cms.offers', 1800, fn () => HomepageOffer::active()->get());

        return response()->json(['data' => $data])->header('Cache-Control', 'public, max-age=600');
    }

    public function banners(): JsonResponse
    {
        $data = Cache::remember('api.cms.banners', 1800, fn () => Banner::where('is_active', true)->orderBy('sort_order')->get());

        return response()->json(['data' => $data])->header('Cache-Control', 'public, max-age=600');
    }
}
