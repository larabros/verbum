<?php

namespace Larabros\Verbum;

class Vox
{
    private $locale        = null;
    private $directory     = null;
    private $defaultLocale = 'en_GB';
    private $copy          = [];
    private $defaultCopy   = [];

    /**
     * Create a new Vox Instance
     */
    public function __construct($locale, $directory, $default = 'en_GB')
    {
        $this->locale        = $locale;
        $this->directory     = $directory;
        $this->defaultLocale = $default;
    }

    /**
     * Loads the copy if not loaded already
     *
     * @return array void
     */
    private function load($key)
    {
        if (!array_key_exists($key, $this->copy)) {
            $parts = explode('.', $key);
            $name  = $parts[0];

            $file    = "{$this->directory}/{$name}_{$this->locale}.php";
            $default = "{$this->directory}/{$name}_{$this->defaultLocale}.php";

            if (file_exists($file)) {
                $this->copy[$name] = require $file;
            } else {
                $this->copy[$name] = [];
            }

            if (file_exists($default)) {
                $this->defaultCopy[$name] = require $default;
            } else {
                $this->defaultCopy[$name] = [];
            }

            $this->copy = $this->array_dot($this->copy);
            $this->defaultCopy = $this->array_dot($this->defaultCopy);
        }
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array   $array
     * @param  string  $prepend
     * @return array
     */
    private function array_dot($array, $prepend = '')
    {
        $results = array();
        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $results = array_merge($results, $this->dot($value, $prepend.$key.'.'));
            }
            else
            {
                $results[$prepend.$key] = $value;
            }
        }
        return $results;
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array   $array
     * @param  string  $prepend
     * @return array
     */
    private function dot($array, $prepend = '')
    {
        $results = array();
        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $results = array_merge($results, $this->dot($value, $prepend.$key.'.'));
            }
            else
            {
                $results[$prepend.$key] = $value;
            }
        }
        return $results;
    }

    /**
     * Retrieve the localised copy for the given string
     *
     * @param string $key {filename}.{key} format
     *
     * @return string Returns the localised copy
     */
    public function get($key)
    {
        $this->load($key);

        if (array_key_exists($key, $this->copy)) {
            return $this->copy[$key];
        }

        return isset($this->defaultCopy[$key]) ? $this->defaultCopy[$key] : '';
    }
}
