<?php

namespace App\Observers;


use App\Services\Navigation;

class ClearNavigationCache
{
    private $navigation;

    public function __construct()
    {
        $this->navigation = app(Navigation::class);
    }

    public function created($category)
    {
        if ($category->is_nav || $this->isUsedToBeNav($category))
            $this->navigation->clearCache();
    }

    public function deleted($category)
    {
        if ($category->is_nav || $this->isUsedToBeNav($category))
            $this->navigation->clearCache();
    }

    public function saved($category)
    {
        if ($category->is_nav || $this->isUsedToBeNav($category))
            $this->navigation->clearCache();
    }

    /**
     * 是否曾经是导航栏
     */
    private function isUsedToBeNav($category)
    {
        foreach ($this->navigation->getAllNav() as $nav) {
            if ($category->is($nav)) return true;
            if ($category->hasChildren()) {
                foreach ($category->children as $child) {
                    if($category->is($child)){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
