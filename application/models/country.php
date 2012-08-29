<?php
    
    class Country{
        
        private static $table = 'Country';
        private $country;



        function __construct($country_id = null){
            
            $country = DB::table(self::$table)->where('countryId', '=', $country_id)->first();

            // say something if no country found.
            if( empty($country) ) throw new Exception('Country ' . $country_id . ' not found');

            // store the retrieved country.
            $this->country = $country;

        }


        
        // get country name.
        function get_name(){
            
            return $this->country->name;

        }



        // get all country names.
        static function get_all_names(){
            
            $names = array();
            $countries = DB::table(self::$table)->order_by('name')->get('name');

            // maybe it won't hurt to reformat a 277 result of country names.
            foreach( $countries as $country ){
                
                $names[] = $country->name;

            }

            return $names;

        }

    }

?>
