<?php namespace Widget\Services;

use Config, HTML, View, Helpers;
use Widget\Entities\Types\WidgetTypes;
use Widget\Entities\Types\DisplayWidgets;
use Widget\Entities\Types\FormWidgets;

//This little bastard renders the widget code!!
class ClientRender {
    public function __construct(WidgetTypes $widget_type_obj) {
        $this->widget_type_obj    = $widget_type_obj; 
        $this->widget_loader_url  = Config::get('application.deploy_env')."/widget/widget_loader/";
        $this->form_loader_script = trim(HTML::script('js/s36_client_script.js'));
        $this->form_loader_css    = trim(HTML::style('css/s36_client_style.css'));
        $this->tab_position_css_output = Helpers::tab_position_css_output();
    }  

    public function js_output() {
        $obj = $this->widget_type_obj;
        if($obj instanceof FormWidgets) {
            $data = Array(
                'js_load' => $this->form_loader_script
              , 'css_load' => $this->form_loader_css
              , 'tab_pos' => $obj->get_tab_pos()
              , 'tab_type' => $obj->get_tab_type()
              , 'widget_loader_url' => $this->_widget_loader($obj->widgetkey)
              , 'tab_position_css' => $this->tab_position_css_output
            );
            return View::make('widget/widget_js_output_form', $data)->get();
        }

        if($obj instanceof DisplayWidgets) {
            $data = Array(
                'js_load'  => $this->form_loader_script
              , 'css_load' => $this->form_loader_css
              , 'widget_loader_url' => $this->_widget_loader($obj->widgetkey)
              , 'widget_child_loader_url' => $this->_widget_loader($obj->get_child())
              , 'height' => $obj->get_height()
              , 'width' => $obj->get_width()
              , 'embed_block_type' => $obj->get_embed_block_type()
              , 'class_name' => $obj->my_name()
            );

            return View::make('widget/widget_js_output_display', $data)->get(); 
        }
    }

    public function link_js_output() { 
        $obj = $this->widget_type_obj;

        if($obj instanceof FormWidgets) {
            $data = Array(
                'js_load' => $this->form_loader_script
              , 'css_load' => $this->form_loader_css
              , 'widget_loader_url' => $this->_widget_loader($obj->widgetkey)
            );
            return View::make('widget/widget_link_js_output_form', $data)->get();
        }
    }

    public function iframe_output() {
        $obj = $this->widget_type_obj;

        if($obj instanceof FormWidgets) {
            $height = $obj->get_height();
            $width = $obj->get_width();
            return '<a href="'.$this->_widget_loader($obj->widgetkey).'" 
                       onclick="window.open(this.href,  null, \'height='.$height.', width='.$width.', toolbar=0, location=0, status=1, scrollbars=1, resizable=1\'); 
                                return false;">Please fill out my form.</a>';
        }

        if($obj instanceof DisplayWidgets) {
            $data = Array(
                'js_load' => $this->form_loader_script 
              , 'css_load' => $this->form_loader_css
              , 'widget_loader_url' => $this->_widget_loader($obj->widgetkey)
              , 'widget_child_loader_url' => $this->_widget_loader($obj->get_child())
              , 'height' => $obj->get_height()
              , 'width' => $obj->get_width()
              , 'embed_block_type' => $obj->get_embed_block_type()
            );
            return $data['js_load']
                  .$data['css_load']
                  .'<div style="position:relative;width:'.$data['width'].'px;height:'.$data['height'].'px;">' 
                  .'<div class="s36_'.$data['embed_block_type'].'"><a href="javascript:;" onclick="s36_openForm(\''.$data['widget_child_loader_url'].'\')">Send Feedback</a></div>' 
                  .'<iframe id="s36Widget" allowTransparency="true" 
                            height="'.$data['height'].'" width="'.$data['width'].'" 
                            frameborder="0" scrolling="no" style="width:100%;border:none;overflow:hidden;" src="'.$data['widget_loader_url'].'">Insomnia wooohooooh</iframe>
                   </div>';
        }
        
    }

    private function _widget_loader($widget_key) {
        return trim($this->widget_loader_url.$widget_key);
    }
}
