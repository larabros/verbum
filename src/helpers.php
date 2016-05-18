<?php
if (!function_exists('vox'))
{
    function vox($key)
    {
        $value = call_user_func_array([\Larabros\Verbum\Vox::$class, 'get'], [$key]);
        var_dump($value);
    }
}
