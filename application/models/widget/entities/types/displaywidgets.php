<?php namespace Widget\Entities\Types;

use Widget\Entities\Types\WidgetTypes;

class DisplayWidgets extends WidgetTypes { 
    public function get_embed_block_type() {
        return $this->embed_block_type; 
    }

    public function get_child() {
        $child_key = null;
        if($this->children) {
            foreach($this->children as $child) { 
                $child_key = $child->widgetkey; 
            }
        }
        return $child_key;
    }
}
