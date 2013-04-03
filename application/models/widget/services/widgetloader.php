<?php namespace Widget\Services;

use StdClass, Config, Helpers;
use Widget\Repositories\DBWidget;

class WidgetLoader {

    private $dbh;
    public $widget_obj;

    public function __construct($widget_id) {
        $this->dbw = new DBWidget;
        $this->widget_obj = $this->dbw->fetch_widget_by_id($widget_id); 
    }

    public function load() {

        $obj = $this->widget_obj;
        $wf = new WidgetFactory; 

        if($obj) {
            if($obj->widget_type == 'display') {
                $params = Array(
                    'company_id'   => $obj->company_id
                  , 'site_id'      => $obj->site_id
                  , 'is_published' => 1
                  , 'is_featured'  => 1
                );

                $feedback = new \Feedback\Repositories\DBFeedback;       
                $data = $feedback->pull_feedback_by_company($params);

                $fixed_data = Array();
                foreach ($data->result as $rows) {
                   //check if feedback is locked use global widget display rules
                   if ($rows->indlock == 1) { 
                       $feed_rules = $obj->perms;    
                   } else {
                   //ok feedback has it's own set of display rules
                       $feed_rules = new StdClass;
                       $feed_rules->displayname     = $rows->displayname;
                       $feed_rules->displayimg      = $rows->displayimg;
                       $feed_rules->displaycompany  = $rows->displaycompany;
                       $feed_rules->displayposition = $rows->displayposition;
                       $feed_rules->displayurl      = $rows->displayurl;
                       $feed_rules->displaycountry  = $rows->displaycountry;
                       $feed_rules->displaysbmtdate = $rows->displaysbmtdate;
                   }

                   $rows->rules = (object)$feed_rules;
                   $fixed_data[] = $rows;
                }
 
                $obj->widget = $obj->embed_type;
                $obj->embed_block_type = (property_exists($obj, 'embed_block_type') && $obj->embed_block_type) ? $obj->embed_block_type : 'embed_block_x';
                $obj->fixed_data = $fixed_data; 
                $obj->total_rows = $data->total_rows;
                
                return $wf->load_widget($obj); 
            }

            if($obj->widget_type == 'submit') {
                $option = new StdClass;
                $option->site_id    = $obj->site_id;
                $option->company_id = $obj->company_id;
                $option->submit_form_text  = $obj->submit_form_text;
                $option->submit_form_question = $obj->submit_form_question;
                $option->theme_type = $obj->theme_type;
                $option->widget = $obj->embed_type;
                $option->widgetkey = $obj->widgetkey;
                $option->tab_type = $obj->tab_type;
                $option->tab_pos  = $obj->tab_pos;
                return $wf->load_widget($option);
            } 
        }

    }

    public function load_widget_init_js_code() {
        $deploy_env = Config::get('application.deploy_env');
        $widgetkey = "'".$this->widget_obj->widgetkey."'";
        $frame_url = str_replace("https://", '', $deploy_env)."/widget/js_output?widgetId=\"+widgetId+\"";  

        $html = '
            <script type="text/javascript">
                var widgetId = '.$widgetkey.';
                var host = (("https:" == document.location.protocol) ? "https://" : "http://");
                document.write(unescape("%3Cscript src=\'" + host + "'.$frame_url.'\' type=\'text/javascript\'%3E%3C/script%3E"));
            </script>
        ';

        return trim($html);
    }

    public function load_iframe_code() {
        $widget = $this->load();
        $client = new ClientRender($widget);
        return $client->iframe_output();
    }    
}
