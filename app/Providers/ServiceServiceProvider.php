<?php

namespace App\Providers;

use App\Services\Alert;
use App\Services\CategoryService;
use App\Services\CustomOrder;
use App\Services\HTMLPurifier;
use App\Services\Navigation;
use App\Services\PostService;
use App\Services\SettingCacheService;
use App\Services\SlugGenerator;
use App\Services\TagService;
use App\Services\TemplateService;
use App\Services\VisitorService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(CategoryService::class, function () {
            return new CategoryService();
        });

        $this->app->singleton(PostService::class, function () {
            return new PostService();
        });

        $this->app->singleton(SettingCacheService::class, function () {
            return new SettingCacheService();
        });

        $this->app->singleton(CustomOrder::class, function () {
            return new CustomOrder();
        });

        $this->app->singleton(SlugGenerator::class, function () {
            return new SlugGenerator();
        });

        $this->app->singleton(VisitorService::class, function ($app) {
            return new VisitorService($app->make('request'));
        });

        $this->app->singleton(Alert::class, function ($app) {
            return new Alert($app->make('session.store'), $app->make('config')->get('alert'));
        });

        $this->app->singleton(Navigation::class, function () {
            return new Navigation();
        });

        // TemplateService 中注册了 theme 视图命名空间， 因此不管有没有使用此类都需要创建此类
        $this->app->instance(TemplateService::class, new TemplateService(config('template')));

        $this->app->singleton(TagService::class, function () {
            return new TagService();
        });

        $this->app->singleton(HTMLPurifier::class, function ($app) {
            return new HTMLPurifier($app['files']);
        });
    }
}
