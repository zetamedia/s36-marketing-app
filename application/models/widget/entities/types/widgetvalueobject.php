<?php namespace Widget\Entities\Types;

abstract class WidgetValueObject { 
    public function __construct($input_data) {
        $this->input_data = $input_data; 
    }

    public function data() {}
}
