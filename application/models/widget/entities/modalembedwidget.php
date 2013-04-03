<?php namespace Widget\Entities;

use HTML, View, \Widget\Entities\Types\DisplayWidgets;

class ModalEmbedWidget extends DisplayWidgets {

    protected $width = 760;
    protected $height = 500;

    public function __construct($options) {
        $this->widgetkey  = $options->widgetkey;
        $this->form_text  = $options->form_text;
        $this->fixed_data = $options->fixed_data;
        $this->total_rows = $options->total_rows;
        $this->embed_block_type = $options->embed_block_type;
        $this->children  = $options->children;
        $this->css  = HTML::style('themes/widget/'.$options->theme_type.'/css/'.$options->theme_type.'_popup_style.css');
        $this->js = HTML::script('js/widget/display/popup.js');  
    } 

    public function render_data() {
        $widget_view = 'widget/widget_modal_popup_view';
        return View::of_widget_layout()->partial('contents', $widget_view, Array(
            'result' => $this->fixed_data, 'row_count' => $this->total_rows, 'flavor_text' => $this->form_text, 'css' => $this->css, 'js' => $this->js
        ))->get();
    }
}
