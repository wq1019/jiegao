<?php

use App\Repositories\SettingRepository;
use App\Services\HTMLPurifier;
use App\Services\SettingCacheService;
use App\Services\TemplateService;

if (!function_exists('setting')) {
    /**
     * 获取或设置网站设置
     * 获取: setting('setting_name', 'default_value');
     * 设置: 1. setting(['setting_name1' => 'value1', 'setting_name2' => 'value2']);
     *      2. setting(['setting_name1' => ['value' => 'value_test', 'is_system' => true]]);.
     *
     * @param null $name
     * @param null $default
     *
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

        if (empty($config)) {
            $config = config('images');
        }

        if ($config['source_disk'] == 'local') {
            $parameters = ['image' => $imageId];

            if (is_array($style)) {
                $parameters = array_merge($parameters, $style);
            } elseif (is_string($style)) {
                $parameters['p'] = $style;
            }

            return route(config('images.route_name'), $parameters);
        } else {
            $path = $config['source_path_prefix'].'/'.substr($imageId, 0, 2).'/'.$imageId;

            if (is_array($style)) {
                $style = array_merge($config['default_style'], $style);
            } elseif (isset($config['presets'][$style])) {
                $style = array_merge($config['default_style'], $config['presets'][$style]);
            } else {
                $style = null;
            }

            if (!empty($style)) {
                if (isset($style['q'])) {
                    $q = "q/{$style['q']}|imageslim";
                } else {
                    $q = '';
                }
                // $parameters = "?imageView2/1/w/{$style['w']}/h/{$style['h']}" . $q;

                $parameters = '?imageView2/1/'.(isset($style['w']) ? "w/{$style['w']}/" : '').(isset($style['h']) ? "h/{$style['h']}/" : '').$q;
            } else {
                $parameters = '';
            }

            return Storage::disk($config['source_disk'])->url($path).$parameters;
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

if (!function_exists('sign_color')) {
    function sign_color($primitive_string, $keywords, $color = 'red')
    {
        $pos = strrpos($primitive_string, $keywords);
        if ($pos == 0 || $pos) {
            $pos = true;
        } else {
            $pos = false;
        }
        if ($keywords != '' && $pos) {
            $new_string = str_ireplace($keywords, "<span style='color: $color'>".$keywords.'</span>', $primitive_string);
        }
        // todo >=php7
        return $new_string ?? $primitive_string;
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

        return round($bytes, 2).' '.$units[$i];
    }
}

if (!function_exists('clean')) {
    function clean($html, $config = null)
    {
        return app(HTMLPurifier::class)->clean($html, $config);
    }
}

if (!function_exists('is_mobile')) {
    function is_mobile()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        $useragent = $_SERVER['HTTP_USER_AGENT'];

        return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)) === 1;
    }
}
