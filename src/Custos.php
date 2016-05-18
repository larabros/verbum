<?php

namespace Larabros\Verbum;

class Custos
{
    private static $class  = null;
    private $url           = '/';
    private $locale        = null;
    private $path          = '/';
    private $defaultLocale = 'en_GB';
    private $copyLocation  = null;
    private $vox           = null;
    private $mapping       = ['GB' => 'en_GB','AU' => 'en_AU', 'AE' => 'en_AE', 'IN' => 'en_IN', 'IE' => 'en_IE', 'NZ' => 'en_NZ', 'ZA' => 'en_ZA', 'DE' => 'de_DE', 'AT' => 'de_AT', 'CH' => 'de_CH', 'FR' => 'fr_FR', 'BE' => 'fr_BE', 'LU' => 'fr_LU', 'CZ' => 'cs_CZ', 'DK' => 'da_DK', 'GR' => 'el_GR', 'ES' => 'es_ES', 'IT' => 'it_IT', 'NL' => 'nl_NL', 'NO' => 'no_NO', 'SE' => 'sv_SE', 'FI' => 'fi_FI', 'RU' => 'ru_RU', 'PT' => 'pt_PT', 'PL' => 'pl_PL', 'TR' => 'tr_TR', 'LV' => 'en_LV', 'LT' => 'en_LT', 'EE' => 'en_EE'];

    /**
     * Create a new Custos instance
     */
    public function __construct($location = null, $url = '/')
    {
        $this->locale       = $this->detectLocale();
        $this->url          = $url;
        $this->copyLocation = $location;
    }

    public static function init($location = null, $url = '/')
    {
        self::$class = new Custos($location, $url);
        return self::$class->handle();
    }

    private function getLocaleFromUrl()
    {
        $matches = [];
        preg_match('~^/[a-z]{2}_[A-Z]{2}(?:/|$)~', $_SERVER['REQUEST_URI'], $matches);
        return isset($matches[0]) ? $matches[0] : null;
    }

    private function getLocaleFromGeo()
    {
        $country = false;

        try {
            $country = isset($_SERVER['GEOIP_COUNTRY_CODE']) ? $_SERVER['GEOIP_COUNTRY_CODE'] : false;
        }catch( Exception $e ){ }

        if(false !== $country && array_key_exists($country, $this->mapping)) {
            $locale = $this->mapping[$country];

            if ($this->validateLocale($locale)) {
                return $locale;
            }
        }

        return $this->defaultLocale;
    }

    private function detectLocale()
    {
        if (null == ($locale = $this->getLocaleFromUrl())) {
            $locale = $this>getLocaleFromGeo();
            header('location: /' . $locale);
            exit;
        }

        return $locale;
    }

    private function validate()
    {
        // ToDo: remember that we also have locales such as en_ANZ
        return strlen($this->locale) == 5 && 2 == strpos($this->locale, '_') && count(glob($this->copyLocation . '/*_' . $this->locale . '.php'));
    }

    private function handle()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->vox = new Vox($this->locale, $this->copyLocation);

        return $this->vox;
    }
}
