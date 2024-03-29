<?php
    
    namespace Account\Entities;
    use DBPlan;
    
    class FormData{
        
        private $data;
        
        
        function __construct($input){
            
            $this->data = $input;
            
        }
        
        
        
        function get($key = null){
            
            // if $key is not given, return the whole $this->data.
            if( is_null($key) ) return $this->data;
            
            // if $key doesn't exist in $this->data, return null.
            if( ! property_exists($this->data, $key) ) return null;
            
            // if $key is known to humanity, return it from $this->data.
            return $this->data->$key;
            
        }
        
        
        
        // get the valid plans.
        function get_valid_plans(){
            
            // get the valid plans.
            $valid_plans = array_map('strtolower', DBPlan::get_all_names());

            // add "secret" to valid plans.
            $valid_plans[] = 'secret';
            
            // remove "basic" to valid plans.
            unset( $valid_plans[array_search('basic', $valid_plans)] );
            
            return $valid_plans;
            
        }
        
    }
    
?>