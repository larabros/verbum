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
    private $mapping       = [
        'GB' => 'en_GB',
        'AU' => 'en_AU',
        'AE' => 'en_AE',
        'IN' => 'en_IN',
        'IE' => 'en_IE',
        'NZ' => 'en_NZ',
        'ZA' => 'en_ZA',
        'DE' => 'de_DE',
        'AT' => 'de_AT',
        'CH' => 'de_CH',
        'FR' => 'fr_FR',
        'BE' => 'nl_BE',
        'LU' => 'fr_LU',
        'CZ' => 'cs_CZ',
        'DK' => 'da_DK',
        'GR' => 'el_GR',
        'ES' => 'es_ES',
        'IT' => 'it_IT',
        'NL' => 'nl_NL',
        'NO' => 'no_NO',
        'SE' => 'sv_SE',
        'FI' => 'fi_FI',
        'RU' => 'ru_RU',
        'PT' => 'pt_PT',
        'PL' => 'pl_PL',
        'TR' => 'tr_TR',
        'LV' => 'en_LV',
        'LT' => 'en_LT',
        'EE' => 'en_EE'
    ];

    public $countries = [
        'en_GB' => 'United Kingdom',
        'en_AU' => 'Australia',
        'en_AE' => 'United Arab Emirates',
        'en_IN' => 'India',
        'en_IE' => 'Ireland',
        'en_NZ' => 'New Zealand',
        'en_ZA' => 'South Africa',

        'de_DE' => 'Deutschland',
        'de_AT' => 'Österreich',
        'de_CH' => 'Schweiz',
        'de_LU' => 'Luxemburg',

        'es_ES' => 'España',

        'it_IT' => 'Italia',

        'it_CH' => 'Svizzera',
        'fr_CH' => 'Suisse',

        'el_GR' => 'Ελλάδα',
        'nl_NL' => 'Nederland',
        'nl_BE' => 'België',
        'pl_PL' => 'Polska',
        'pt_PT' => 'Portugal',
        'ru_RU' => 'Россия',
        'tr_TR' => 'Türkiye',

        'fr_FR' => 'France',
        'fr_BE' => 'Belgique',
        'fr_LU' => 'Luxembourg',

        'cs_CZ' => 'Česká republika',
        'da_DK' => 'Danmark',
        'no_NO' => 'Norge',
        'sv_SE' => 'Sverige',
        'fi_FI' => 'Suomi',
    ];

    public $englishCountries = [
        'A' => [
            'en_AU' => 'Australia',
            'de_AT' => 'Austria',
        ],
        'B' => [
            'fr_BE' => 'Belgium (Français)',
            'nl_BE' => 'Belgium (Nederlands)',
        ],
        'C' => [
            'cs_CZ' => 'Czech Republic',
        ],
        'D' => [
            'da_DK' => 'Denmark',
        ],
        'F' => [
            'fi_FI' => 'Finland',
            'fr_FR' => 'France',
        ],
        'G' => [
            'de_DE' => 'Germany',
            'el_GR' => 'Greece',
        ],
        'I' => [
            'en_IN' => 'India',
            'en_IE' => 'Ireland',
            'it_IT' => 'Italy',
        ],
        'L' => [
            'de_LU' => 'Luxembourg (Deutsch)',
            'fr_LU' => 'Luxembourg (Français)',
        ],
        'N' => [
            'nl_NL' => 'Nederland',
            'en_NZ' => 'New Zealand',
            'no_NO' => 'Norway',
        ],
        'P' => [
            'pl_PL' => 'Poland',
            'pt_PT' => 'Portugal',
        ],
        'R' => [
            'ru_RU' => 'Russia',
        ],
        'S' => [
            'en_ZA' => 'South Africa',
            'es_ES' => 'Spain',
            'sv_SE' => 'Sweden',
            'de_CH' => 'Switzerland (Deutsch)',
            'fr_CH' => 'Switzerland (Français)',
            'it_CH' => 'Switzerland (Italiano)',
        ],
        'T' => [
            'tr_TR' => 'Turkey',
        ],
        'U' => [
            'en_AE' => 'United Arab Emirates/ Middle East',
            'en_GB' => 'United Kingdom',
        ],
    ];

    public $languages = [
        'en_GB' => 'English',
        'en_AU' => 'English',
        'en_AE' => 'English',
        'en_IN' => 'English',
        'en_IE' => 'English',
        'en_NZ' => 'English',
        'en_ZA' => 'English',

        'de_DE' => 'Deutsch',
        'de_AT' => 'Deutsch',
        'de_CH' => 'Deutsch',

        'es_ES' => 'Español',

        'it_IT' => 'Italiano',
        'it_CH' => 'Italiano',

        'el_GR' => 'ΕΛΛΗΝΙΚΑ',
        'nl_NL' => 'Nederlands',
        'pl_PL' => 'Polskie',
        'pt_PT' => 'Português',
        'ru_RU' => 'Русский',
        'tr_TR' => 'Türkçe',

        'fr_FR' => 'FRANÇAIS',
        'fr_BE' => 'FRANÇAIS',
        'fr_LU' => 'FRANÇAIS',

        'cs_CZ' => '',
        'da_DK' => '',
        'no_NO' => '',
        'sv_SE' => '',
        'fi_FI' => '',
        'en_LV' => '',
        'en_LT' => '',
        'en_EE' => '',
    ];

    /**
     * Create a new Custos instance
     */
    public function __construct($location = null, $url = '/')
    {
        $this->url          = $url;
        $this->copyLocation = $location;
    }

    public static function init($location = null, $url = '/')
    {
        self::$class = new Custos($location, $url);
        self::$class->handle();
        return self::$class;
    }

    private function getLocaleFromUrl()
    {
        $matches = [];
        preg_match('~[a-z]{2}_[A-Z]{2}(?:/|$)~', $_SERVER['REQUEST_URI'], $matches);
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

            if ($this->validate($locale)) {
                return $locale;
            }
        }

        return $this->defaultLocale;
    }

    private function detectLocale()
    {
        if (null == ($locale = $this->getLocaleFromUrl())) {

            $locale = $this->getLocaleFromGeo();
            header('location: ' . $this->url . $locale);
            exit;
        }

        $this->locale = rtrim(ltrim($locale, '/'), '/');

        if (!$this->validate()) {
            header('location: ' . $this->url . $this->defaultLocale);
            exit;
        }

        return $this->locale;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getLanguage()
    {
        return $this->languages[$this->locale];
    }

    public function getCountry()
    {
        return $this->countries[$this->locale];
    }

    public function getLanguages()
    {
    }

    private function validate($locale = null)
    {
        $l = $locale ? $locale : $this->locale;
        return strlen($l) == 5 && 2 == strpos($l, '_') && count(glob($this->copyLocation . '/*_' . $l . '.php'));
    }

    private function handle()
    {
        $this->detectLocale();

        if (!$this->validate()) {
            return false;
        }

        $this->vox = new Vox($this->locale, $this->copyLocation);

        return $this->vox;
    }
}
