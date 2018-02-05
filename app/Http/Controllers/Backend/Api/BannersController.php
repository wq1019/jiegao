<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Backend\BannerCreateRequest;
use App\Http\Requests\Backend\BannerUpdateRequest;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use App\Services\CustomOrder;
use App\Transformers\Backend\BannerTransformer;
use Illuminate\Http\Request;

class BannersController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $banners = Banner::byType($request->get('type_name', null))->ancient()->get();
        $banners = app(CustomOrder::class)->order($banners);

        return $this->response()->collection($banners, new BannerTransformer());
    }

    public function store(BannerCreateRequest $request, BannerRepository $bannerRepository)
    {
        $bannerRepository->create($request->validated());

        return $this->response()->noContent();
    }

    public function update(Banner $banner, BannerUpdateRequest $request, BannerRepository $bannerRepository)
    {
        $bannerRepository->update($request->validated(), $banner);

        return $this->response()->noContent();
    }

    public function show(Banner $banner)
    {
        return $this->response()->item($banner, new BannerTransformer());
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return $this->response()->noContent();
    }
}
