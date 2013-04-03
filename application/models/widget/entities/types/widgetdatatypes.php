<?php namespace Widget\Entities\Types;

use Widget\Repositories\DBWidget;
use DB, Input, Helpers;
 
//TODO: You can do better than this...
abstract class WidgetDataTypes {

    public $make_default = False;

    private $_dbw, $_id, $data;

    public function __construct() {
        $this->_dbw = new DBWidget;
    }

    public function save() {
        if($this->data->widgetkey) {
            $this->update();     
        } else {
            $this->create();         
        } 
    }

    public function create() { 
        $insert_id = $this->_dbw->save_widget($this->data, $this->make_default);
        $this->_dbw->insert_ancestor($insert_id, $insert_id);
        $this->_id = $insert_id; 
    }

    public function update() {
        $this->_dbw->update_widget_by_id($this->data->widgetkey, $this->data);
        $obj = $this->_dbw->fetch_widget_by_id($this->data->widgetkey);
        $this->_id = $obj->widgetstoreid;
    }

    public function delete() {
        $this->_dbw->delete_widget($this->data->widgetkey);
    }

    public function adopt(WidgetDataTypes $child) { 
        //add this child set path length to one
        if(!$this->child_exists($child)) {
            $this->_dbw->insert_ancestor($this->_id, $child->get_widget_id(), 1);        
        } 
    }

    public function child_exists($child) {  
        $obj = $this->_dbw->fetch_widget_by_id($this->_id, $fetch_by='widgetstoreid');
        $child_exists = false;
        if($obj->children) { 
            foreach($obj->children as $my_child) {
                if($my_child->widgetstoreid == $child->get_widget_id()) {
                    $child_exists = true; 
                }
            }
        }

        return $child_exists;
    }

    public function emit() { 
        $obj = $this->_dbw->fetch_widget_by_id($this->_id, $fetch_by='widgetstoreid');
        return Array('widget' => $obj);
    }

    public function get_widget_id() {
        return $this->_id;     
    }

    public function set_widgetdata($data) {
        $site = DB::Table('Site')->where('siteId', '=', $data->site_id)->first(Array('domain'));
        $this->data = $data;     
        $this->data->site_nm = $site->domain; 
    }
}
