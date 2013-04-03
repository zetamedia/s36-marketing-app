<?php namespace Widget\Repositories;

use S36DataObject\S36DataObject, PDO, StdClass, Helpers, DB, S36Auth;
use ZebraPagination\ZebraPagination;

class DBWidget extends S36DataObject {    

    public function delete_widget($widget_id) {
        $obj = $this->fetch_widget_by_id($widget_id);
        $parent_id = $obj->widgetstoreid;
        $child_id = Null;
        if($obj->children) {
            foreach($obj->children as $rows) {
                $child_id = $rows->widgetstoreid;
                $sth = $this->dbh->prepare("DELETE FROM WidgetClosure WHERE ancestor_id = :child_id"); 
                $sth->bindParam(':child_id', $child_id, PDO::PARAM_STR);
                $sth->execute();

            }
        }
 
        $sth = $this->dbh->prepare("DELETE FROM WidgetClosure WHERE ancestor_id = :parent_id"); 
        $sth->bindParam(':parent_id', $parent_id, PDO::PARAM_STR);
        $sth->execute();

        $sth = $this->dbh->prepare("DELETE FROM WidgetStore WHERE widgetStoreId = :widget_store_id");
        $sth->bindParam(':widget_store_id', $parent_id, PDO::PARAM_STR);
        $sth->execute();
       
        if($obj->children) { 
            $sth = $this->dbh->prepare("DELETE FROM WidgetStore WHERE widgetStoreId = :child_store_id");
            $sth->bindParam(':child_store_id', $child_id, PDO::PARAM_STR);
            $sth->execute();
        }
    }

    public function save_widget($widget_obj, $make_default=false) {

        $widget_key = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
        
        if($make_default) { 
            $sql = "INSERT INTO WidgetStore (widgetKey, widgetType, isDefault, companyId, siteId, widgetObjString) 
                                     VALUES (:widget_key, :widget_type, 1, :company_id, :site_id, :widget_string)";
        } else {
            
            $sql = "INSERT INTO WidgetStore (widgetKey, widgetType, companyId, siteId, widgetObjString) 
                                     VALUES (:widget_key, :widget_type, :company_id, :site_id, :widget_string)";
        }

        $widget_obj_string = base64_encode(serialize($widget_obj));

        $this->dbh->beginTransaction();
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        $sth->bindParam(':widget_type', $widget_obj->widget_type, PDO::PARAM_STR);
        $sth->bindParam(':company_id', $widget_obj->company_id, PDO::PARAM_INT);
        $sth->bindParam(':site_id', $widget_obj->site_id, PDO::PARAM_INT);
        $sth->bindParam(':widget_string', $widget_obj_string, PDO::PARAM_STR);
        $sth->execute();

        $last_insert_id = $this->dbh->lastInsertId();
        $this->dbh->commit();
        return $last_insert_id;
    }

    public function update_widget_by_id($widget_key, $widget_obj) {
        $widget_obj_string = base64_encode(serialize($widget_obj));
        $sql = "UPDATE WidgetStore
                    SET widgetObjString = :widget_string, siteId = :site_id
                WHERE 1=1
                    AND widgetKey = :widget_key";
        
        $sth = $this->dbh->prepare($sql);  
        $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        $sth->bindParam(':widget_string', $widget_obj_string, PDO::PARAM_STR);
        $sth->bindParam(':site_id', $widget_obj->site_id, PDO::PARAM_STR);
        $sth->execute();
        return Array('status' => 'update', 'widget' => $widget_obj);
    }

    public function insert_ancestor($ancestor_id, $descendant_id, $path_length=0) {  
        $this->dbh->beginTransaction();
        $closure_sql = "INSERT INTO WidgetClosure (ancestor_id, descendant_id, path_length) VALUES (:ancestor_id, :descendant_id, :path_length)"; 
        $sth = $this->dbh->prepare($closure_sql);
        $sth->bindParam(':ancestor_id', $ancestor_id, PDO::PARAM_INT);
        $sth->bindParam(':descendant_id', $descendant_id, PDO::PARAM_INT);
        $sth->bindParam(':path_length', $path_length, PDO::PARAM_INT);
        $sth->execute();
        $this->dbh->commit();
    }

    public function fetch_widget_by_id($widget_key, $fetch_by='widgetkey') {     
        //FIX to avoid aggregation bugs. Ensure that only ONE widget is returned. 
        if($fetch_by == "widgetkey") {
            $statement = "AND WidgetStore.widgetKey = :widget_key";
        } else { 
            $statement = "AND WidgetStore.widgetStoreId = :widget_store_id";
        }
 
        $sql = "
            SELECT 
                  WidgetStore.widgetStoreId
                , WidgetStore.widgetKey
                , WidgetStore.widgetObjString
                , WidgetClosure.path_length
            FROM 
                WidgetStore
            INNER JOIN
                WidgetClosure
                    ON WidgetStore.widgetStoreId = WidgetClosure.descendant_id
            WHERE 1=1
                AND WidgetClosure.ancestor_id = (
                    SELECT 
                        WidgetStore.widgetStoreId
                    FROM
                        WidgetStore
                    WHERE 1=1
                        $statement
                )
            ORDER BY
                WidgetStore.widgetStoreId DESC
        ";
 
        $sth = $this->dbh->prepare($sql);  
        if($fetch_by == "widgetkey") {
            $sth->bindParam(':widget_key', $widget_key, PDO::PARAM_STR);
        } else { 
            $sth->bindParam(':widget_store_id', $widget_key, PDO::PARAM_STR);
        }
        
        $sth->execute();
        
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        
        if($result) {
            $node = new StdClass;
            $child = Array();
            foreach($result as $rows) {
                //path of parents is alway zero
                if ( $rows->path_length == 0 ) { 
                    $node = $this->_load_object_code($rows->widgetobjstring);
                    $node->widgetstoreid = $rows->widgetstoreid; 
                } else {
                    $my_kid = $this->_load_object_code($rows->widgetobjstring);
                    $my_kid->widgetstoreid = $rows->widgetstoreid;
                    $my_kid->widgetkey = $rows->widgetkey;
                    $child[] = $my_kid; 
                }

                $node->widgetkey = $rows->widgetkey;
                $node->widgetstoreid = $rows->widgetstoreid;
                $node->children = null;
                if ($child) {
                    $node->children = $child;
                } 
            } 

            return $node;  
        }
    }

    public function fetch_widgets_by_company() {
        $widgets = new StdClass;
        $widgets->display_widgets = $this->fetch_paginated_widgets('display');
        $widgets->form_widgets = $this->fetch_paginated_widgets('submit');
        return $widgets;
    }

    public function fetch_widgets_by($widget_type, $limit=3, $offset=0) { 
        $sql = " 
            SELECT 
                  SQL_CALC_FOUND_ROWS
                  WidgetStore.widgetStoreId
                , WidgetStore.widgetKey
                , WidgetStore.companyId
                , WidgetStore.siteId
                , WidgetStore.widgetObjString
            FROM 
                WidgetStore
            INNER JOIN
                WidgetClosure
                    ON WidgetStore.widgetStoreId = WidgetClosure.descendant_id
            WHERE 1=1
                AND WidgetStore.companyId = :company_id
                AND WidgetStore.widgetType = :widget_type
                AND WidgetStore.isDefault = 0 
            GROUP BY 
                WidgetStore.widgetStoreId
            HAVING 
                NOT COUNT(*) > 1
                /* NOT COUNT(WidgetStore.widgetStoreId) */
            ORDER BY 
                WidgetStore.widgetStoreId DESC 
            LIMIT :offset, :limit 
        ";

        $sth = $this->dbh->prepare($sql);  
        $sth->bindParam(':company_id', $this->company_id, PDO::PARAM_INT);
        $sth->bindParam(':widget_type', $widget_type, PDO::PARAM_INT);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_CLASS);
        
        $data = Array();
        foreach ($result as $rows) {
            $obj = base64_decode($rows->widgetobjstring);
            $obj = unserialize($obj); 
            $rows->widget_obj = $obj;
            $data[] = $rows; 
        }

        $row_count = $this->dbh->query("SELECT FOUND_ROWS()");
        $row_count = $row_count->fetchColumn();
        
        $data_holder = new StdClass;
        $data_holder->widgets = $data;
        $data_holder->total_rows = $row_count;
        return $data_holder;
    }

    public function fetch_paginated_widgets($type, $limit=5) {

        $pagination = new ZebraPagination;  
        $pagination->method('url');
        $pagination->base_url('/feedsetup/ajax_overview/'.$type);
        $pagination->selectable_pages(5);

        $offset = ($pagination->get_page() - 1) * $limit;

        $widgets = $this->fetch_widgets_by($type, $limit, $offset);

        $pagination->records($widgets->total_rows);
        $pagination->records_per_page($limit);

        $result = new stdClass;
        $result->widget = $widgets;
        $result->pagination = $pagination->render();

        return $result; 
    }

    public function fetch_canonical_widget($company_id) { 
        $sql = "
                SELECT 
                    WidgetStore.widgetKey 
                FROM 
                    Company 
                INNER JOIN
                    WidgetStore
                        ON Company.companyId = WidgetStore.companyId
                WHERE 1=1 
                    AND Company.name = :company_id
                    AND WidgetStore.isDefault = 1      
                ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':company_id', $company_id);
        $sth->execute();

        $result = $sth->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    private function _load_object_code($widget_obj_string) {      
        $obj = base64_decode($widget_obj_string);
        $obj = unserialize($obj); 
        return $obj;
    }
}
