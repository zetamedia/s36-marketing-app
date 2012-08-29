<?php
    
    namespace FormData;
    use Input;

    class FormData{
        
        static function registration($key = null){
            
            $input = Input::get();

            $data['test[ching]'] = $input['test']['ching'];
            
            return $data[$key];

        }

    }

?>
