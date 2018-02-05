<?php

namespace App\Services;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use View;

class TemplateService
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        // 判断手机还是电脑访问
        if (is_mobile()) {
            $themePath = $config['mobile'];
        } else {
            $themePath = $config['current_theme_path'];
        }
        View::prependNamespace($config['theme_namespace'], $themePath);
    }

    public function getTemplates($templateTypes = [])
    {
        if (empty($templateTypes)) {
            $templateTypes = array_keys($this->config['templates']);
        } else {
            $templateTypes = Arr::wrap($templateTypes);
        }

        $templates = [];
        foreach ($templateTypes as $templateType) {
            if (isset($this->config['templates'][$templateType])) {
                $templates[$templateType] = $this->config['templates'][$templateType];
                array_swap(
                    $templates[$templateType],
                    0,
                    $this->getDefaultTemplateIndex($templates[$templateType])
                );
            }
        }

        return $templates;
    }

    private function getDefaultTemplateIndex(array $templates)
    {
        foreach ($templates as $key => $template) {
            if (isset($template['default']) && $template['default']) {
                return $key;
            }
        }

        return 0;
    }

    public function firstView(array $templates, $templateType = null)
    {
        $templates = array_map(function ($template) use ($templateType) {
            return $this->config['theme_namespace'].'::'.($templateType ? $templateType.'.' : '').$template;
        }, array_filter($templates));

        $viewFactory = view();

        $view = collect($templates)->first(function ($template) use ($viewFactory) {
            return $viewFactory->exists($template);
        });
        if (!$view && $templateType) {
            $defaultTemplate = $this->getDefaultTemplate($templateType);
            $view = is_null($defaultTemplate) ? null : $this->config['theme_namespace'].'::'.$templateType.'.'.$defaultTemplate['file_name'];
        }

        if (!$view) {
            throw new InvalidArgumentException('None of the views in the given array exist.');
        }

        return $view;
    }

    public function getDefaultTemplate($templateType)
    {
        $templates = $this->config['templates'][$templateType] ?? [];
        if (empty($templates)) {
            return;
        }

        return $templates[$this->getDefaultTemplateIndex($templates)];
    }
}
