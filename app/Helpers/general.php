<?php

if (!function_exists('clean_html')) {
    function clean_html($text = null)
    {
        if ($text) {
            $text = strip_tags($text, '<h1><h2><h3><h4><h5><h6><p><br><ul><li><hr><a><abbr><address><b><blockquote><center><cite><code><del><i><ins><strong><sub><sup><time><u><img><iframe><link><nav><ol><table><caption><th><tr><td><thead><tbody><tfoot><col><colgroup><div><span>');

            $text = str_replace('javascript:', '', $text);
        }
        return $text;
    }
}


if (!function_exists('no_data')) {
    function no_data($title = '', $desc = '', $class = null)
    {
        $title = $title ? $title : __('general.nothing_here');
        $desc = $desc ? $desc : __('general.nothing_here_desc');
        $class = $class ? $class : 'my-4 pb-4';
        $no_data_img = asset('images/no-data.svg');

        $output = " <div class='no-data-screen-wrap text-center {$class} '>
            <img src='{$no_data_img}' style='max-height: 250px; width: auto' />
            <h3 class='no-data-title'>{$title}</h3>
            <h5 class='no-data-subtitle'>{$desc}</h5>
        </div>";
        return $output;
    }
}

if (!function_exists('uploadImage')) {

    function uploadImage($request)
    {
        if (!$request->hasFile('image')) {
            return;
        } else {
            $file = $request->file('image');
            $path = $file->store('users', [
                'disk' => 'public',
            ]);
            return $path;
        }
    }
}
if (!function_exists('get_settings')) {

    function get_settings($object, $type)
        {
            $config = null;
            foreach ($object as $setting) {
                if ($setting['type'] == $type) {
                    $config = $setting;
                }
            }
            return $config;
        }
}
