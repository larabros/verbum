<?php

namespace Larabros\Verbum;

class Custos
{
    private static $class  = null;
    private $locale        = null;
    private $path          = '/';
    private $defaultLocale = 'en_GB';
    private $copyLocation  = null;
    private $vox           = null;

    /**
     * Create a new Custos instance
     */
    public function __construct($locale = null, $location = null)
    {
        $this->locale       = $locale;
        $this->copyLocation = $location;
    }

    public static function init($locale = null, $location = null) {
        self::$class = new Custos($locale, $location);
        return self::$class->handle();
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
