<?php

use App\Services\SettingCacheService;
use App\Repositories\SettingRepository;
use App\Services\TemplateService;

if (!function_exists('setting')) {
    /**
     * 获取或设置网站设置
     * 获取: setting('setting_name', 'default_value');
     * 设置: 1. setting(['setting_name1' => 'value1', 'setting_name2' => 'value2']);
     *      2. setting(['setting_name1' => ['value' => 'value_test', 'is_system' => true]]);
     * @param null $name
     * @param null $default
     * @return SettingCacheService|\Illuminate\Foundation\Application|mixed|null|void
     */
    function setting($name = null, $default = null)
    {
        if (is_null($name)) {
            return app(SettingCacheService::class);
        }

        if (is_array($name)) {
            return app(SettingRepository::class)->set($name);
        }

        $setting = app(SettingCacheService::class)->get($name);

        if (!is_null($setting)) {
            return $setting->value;
        }
        return value($default);
    }

}

if (!function_exists('image_url')) {

    function image_url($imageId, $style = null, $default = null)
    {
        static $config = [];

        if (is_null($imageId)) {
            return value($default);
        }

        if (empty($config))
            $config = config('images');

        if ($config['source_disk'] == 'local') {

            $parameters = ['image' => $imageId];

            if (!is_null($style))
                $parameters['p'] = $style;

            return route(config('images.route_name'), $parameters);

        } else {
            $path = $config['source_path_prefix'] . '/' . substr($imageId, 0, 2) . '/' . $imageId;

            if (isset($config['presets'][$style])) {
                $style = array_merge($config['default_style'], $config['presets'][$style]);
                if (isset($style['q'])) {
                    $q = "/q/{$style['q']}|imageslim";
                } else {
                    $q = '';
                }

                $parameters = "?imageView2/1/w/{$style['w']}/h/{$style['h']}" . $q;
            } else {
                $parameters = '';
            }

            return Storage::disk($config['source_disk'])->url($path) . $parameters;
        }

    }

}

if (!function_exists('array_swap')) {

    function array_swap(&$array, $i, $j)
    {
        if ($i != $j && array_key_exists($i, $array) && array_key_exists($j, $array)) {
            $temp = $array[$i];
            $array[$i] = $array[$j];
            $array[$j] = $temp;
        }
        return $array;
    }

}

if (!function_exists('view_first')) {

    function view_first($views, $templateType, $data = [], $mergeData = [])
    {
        $view = app(TemplateService::class)
            ->firstView($views, $templateType);
        return view($view, $data, $mergeData);
    }

}

if (!function_exists('file_size_for_humans')) {

    function file_size_for_humans($bytes, $times = 0)
    {
        static $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $i = 0;
        $c = count($units);
        while ($bytes >= 1024 && $i < $c - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
