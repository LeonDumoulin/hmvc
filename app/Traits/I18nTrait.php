<?php

namespace App\Traits;

trait I18nTrait
{

    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [];


    /**
     * Magic method for retrieving a missing attribute.
     *
     * @param string $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        // We determine the current locale and return the associated
        // locale-specific attribute e.g. name_en
        if (in_array($attribute, $this->localizable)) {
            $localeSpecificAttribute = $attribute . '_' . app()->getLocale();

            return $this->{$localeSpecificAttribute};
        }

        return parent::__get($attribute);
    }
}