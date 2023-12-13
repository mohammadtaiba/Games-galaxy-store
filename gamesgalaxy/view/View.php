<?php

namespace gamesgalaxy\View;

class View
{
    private string $title;
    public function __set(string $name, string $value)
    {
        if ($name == 'title') {
            error_log("Das ist aber ein schöner Name: $value");
        }
        $this->title = $value;
    }
    final function render_html($callback, $params)
    {
        $this->render_head();
        $this->$callback($params);
        $this->render_footer();
    }
    final function render_head()
    {
        $title = $this->title;
        $css = $this->get_style();
        require_once 'static/html/head.html';
    }
    final function render_footer()
    {
        require_once 'static/html/footer.html';
    }

}
