<?php

namespace App\Support\Widget;

use App\Exceptions\InvalidWidgetClassException;
use Cache;
use Illuminate\Support\HtmlString;

class WidgetFactory
{
    /**
     * @var AbstractWidget
     */
    protected $widget;

    protected $widgetConfig;

    protected $widgetParams;

    protected $widgetName;

    public function render(...$args)
    {
        $this->makeWidget(...$args);
        $content = $this->getContentFromCache();

        return new HtmlString($content);
    }

    protected function makeWidget($widgetName, array $config = [], ...$params)
    {
        $this->widgetName = $widgetName = $this->parseWidgetName($widgetName);
        $this->widgetConfig = $config;
        $this->widgetParams = $params;
        $fullWidgetName = config('widget.root_namespace').'\\'.$widgetName;
        $widgetClass = class_exists($fullWidgetName) ? $fullWidgetName : $widgetName;

        if (!is_subclass_of($widgetClass, AbstractWidget::class)) {
            throw new InvalidWidgetClassException('Class "'.$widgetClass.'" must extend "'.AbstractWidget::class.'" class');
        }

        $this->widget = new $widgetClass($config);
    }

    /**
     * 解析 widget name 例如：news.recentNews => News\RecentNews.
     *
     * @param $widgetName
     *
     * @return string
     */
    protected function parseWidgetName($widgetName)
    {
        return studly_case(str_replace('.', '\\', $widgetName));
    }

    protected function getContentFromCache()
    {
        if ($cacheTime = $this->getCacheTime()) {
            Cache::remember($this->widget->cacheKey($this->widgetConfig), $cacheTime, function () {
                return $this->getContent();
            });
        }

        return $this->getContent();
    }

    protected function getCacheTime()
    {
        return !is_null($this->widget) ? $this->widget->cacheTime : fasle;
    }

    protected function getContent()
    {
        $content = app()->call([$this->widget, 'render'], ['params' => $this->widgetParams]);

        return is_object($content) ? $content->__toString() : $content;
    }
}
