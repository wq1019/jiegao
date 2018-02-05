<?php

namespace App\FakerProviders;

use Faker\Provider\zh_CN\Internet as BaseInternet;

class Internet extends BaseInternet
{
    /**
     * @example 'faber'
     */
    public function domainWord()
    {
        // 这里将原来 lastName 改为 md5 解决了中文 domainWord 问题
        $lastName = $this->generator->format('md5');

        $lastName = strtolower(static::transliterate($lastName));
        // check if transliterate() didn't support the language and removed all letters
        if (trim($lastName, '._') === '') {
            throw new \Exception('domainWord failed with the selected locale. Try a different locale or activate the "intl" PHP extension.');
        }

        // clean possible trailing dot from last name
        $lastName = rtrim($lastName, '.');

        return $lastName;
    }
}
