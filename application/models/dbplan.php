<?php
    
    class DBPlan{
        
        private static $table = 'Plan';
        private $plan;



        function __construct($key = null){
            
            // if $key is numeric, search it planId field,
            if( is_numeric($key) ){
                
                $plan = DB::table(self::$table)->where('planId', '=', $key)->first();
            
            // else, search it in name field.
            }else{
                
                $plan = DB::table(self::$table)->where('name', '=', $key)->first();

            }


            // say something if no plan found.
            if( empty($plan) ) throw new Exception('Plan ' . $key . ' not found');

            // store the retrieved plan.
            $this->plan = $plan;
            
        }



        // get plan's name.
        function get_name(){
            
            return $this->plan->name;

        }



        // get plan's price.
        function get_price(){
            
            return $this->plan->price;

        }



        // get plan's plan id.
        function get_plan_id(){
            
            return $this->plan->planid;

        }



        // get all plan names.
        static function get_all_names(){
            
            $names = array();
            $plans = DB::table(self::$table)->get('name');

            foreach( $plans as $plan ){
                
                $names[] = $plan->name;

            }

            return $names;

        }
        
    }

?>
