<?php
    
    namespace RawPDO;
    use DB;

    class RawPDO{
        
        private static $db = 'master';
        
        // get pdo connection.
        static function get_connection(){
            
            return DB::connection( self::$db )->pdo;

        }

    }

?>
