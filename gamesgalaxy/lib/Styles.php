<?php

function get_style()
{
    $css_file = fopen('static/css/style.css', 'r') or die ("Datei nicht gefunden");
    $css = fread($css_file, filesize("static/css/style.css"));
    fclose($css_file);
    return $css;
}
