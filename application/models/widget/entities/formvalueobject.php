<?php namespace Widget\Entities;

use Input, Helpers;
use \Widget\Entities\Types\WidgetValueObject;

class FormValueObject extends WidgetValueObject {  

    public $widget_type = 'submit';
    public $embed_type = 'form';

    public function data() { 
        $tab_type = null;
        if(isset($this->input_data['tab_type'])) {
            $tab_type = $this->input_data['tab_type'];
        }

        return (object) Array(
            'widgetkey'   => $this->input_data['submit_widgetkey']
          , 'widget_type' => $this->widget_type
          , 'site_id'     => $this->input_data['site_id']
          , 'company_id' => $this->input_data['company_id']
          , 'theme_type' => $this->input_data['theme_type']
          , 'theme_name' => $this->input_data['theme_name']
          , 'embed_type' => $this->embed_type
          , 'submit_form_text'     => $this->input_data['submit_form_text']
          , 'submit_form_question' => $this->input_data['submit_form_question']
          , 'tab_pos'  => Helpers::tab_position($tab_type)
          , 'tab_type' => ($tab_type) ? $tab_type : 'tab-l-aglow'
        );
    }
}
