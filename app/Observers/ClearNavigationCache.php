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
        if ($category->is_nav || $this->isUsedToBeNav($category)) {
            $this->navigation->clearCache();
        }
    }

    /**
     * 是否曾经是导航栏.
     */
    private function isUsedToBeNav($category)
    {
        foreach ($this->navigation->getAllNav() as $nav) {
            if ($category->is($nav)) {
                return true;
            }
            if ($nav->hasChildren()) {
                foreach ($nav->children as $navChild) {
                    if ($category->is($navChild)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function deleted($category)
    {
        if ($category->is_nav || $this->isUsedToBeNav($category)) {
            $this->navigation->clearCache();
        }
    }

    public function saved($category)
    {
        if ($category->is_nav || $this->isUsedToBeNav($category)) {
            $this->navigation->clearCache();
        }
    }
}
