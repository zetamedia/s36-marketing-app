<?php
    
    namespace Account\Repositories;
    use s36dataobject\S36DataObject, Encryption\Encryption, Widget\Entities\FormWidget;
    use DB, Input, DBPlan, PDO;

    class DBAccount extends s36dataobject {

        public $dbh, $user_id;

        public function __construct() {
            
            $this->dbh = DB::connection('master')->pdo;

            //if (S36Auth::check()) {
            //    $this->user_id = S36Auth::user()->userid;             
            // } 
        }

        public function create_account($form_data, $bt_customer_id){
            
            $encrypt = new Encryption();
            $password_string = $form_data->get('password');
            $password = crypt( $password_string );
            $name = $form_data->get('first_name') . ' ' . $form_data->get('last_name');
            $email = $form_data->get('email');
            $encrypt_string = $encrypt->encrypt($email."|".$password_string);
            $company = strtolower( $form_data->get('company') );
            $username = $form_data->get('username');
            //$fullName = $this->escape( $form_data->get('first_name') . ' ' . $form_data->get('last_name') );
            $firstname = $form_data->get('first_name');
            $lastname = $form_data->get('last_name');
            $site = 'www.' . $form_data->get('site_name') . '.com';
            $site_name = strtolower( $form_data->get('site_name') );
            $plan = new DBPlan($form_data->get('plan'));
            $plan_id = $plan->get_plan_id();
            
            $billing_name = $form_data->get('billing_first_name') . ' ' . $form_data->get('billing_last_name');
            $billing_address = $form_data->get('billing_address');
            $billing_city = $form_data->get('billing_city');
            $billing_state = $form_data->get('billing_state');
            $billing_country = $form_data->get('billing_country');
            $billing_zip = $form_data->get('billing_zip');
            $bill_to = "$company, $billing_name, $billing_address, $billing_city, $billing_state, $billing_country, $billing_zip"; 
            
            
            $company_data['name']           = $site_name;
            $company_data['planId']         = $plan_id;
            $company_data['billTo']         = $bill_to;
            $company_data['bt_customer_id'] = $bt_customer_id;
            $company_id = DB::table('Company')->insert_get_id( $company_data );
            
            $metrict_data['companyId']     = $company_id;
            $metrict_data['totalRequest']  = 0;
            $metrict_data['totalResponse'] = 0;
            DB::table('Metric')->insert( $metrict_data );
            
            $site_data['companyId']     = $company_id;
            $site_data['domain']        = $site;
            $site_data['name']          = $site_name;
            $site_data['defaultFormId'] = 1;
            $site_id = DB::table('Site')->insert_get_id( $site_data );
            
            $user_data['companyId']     = $company_id;
            $user_data['username']      = $username;
            $user_data['firstname']     = $firstname;
            $user_data['lastname']      = $lastname;
            $user_data['account_owner'] = 1;
            $user_data['confirmed']     = 1;
            $user_data['password']      = $password;
            $user_data['encryptString'] = $encrypt_string;
            $user_data['email']         = $email;
            $user_data['title']         = 'CEO';
            $user_data['imId']          = 1;
            $user_id = DB::table('User')->insert_get_id( $user_data );
            
            $auth_assignment_data['itemname'] = 'Admin';
            $auth_assignment_data['userid'] = $user_id;
            DB::table('AuthAssignment')->insert( $auth_assignment_data );
            
            DB::query('
                INSERT INTO Category(`companyId`, `intName`, `name`, `changeable`)
                VALUES
                (?, "default", "Inbox", 0) 
                ,(?, "general", "General", 1)
                ,(?, "misc", "Miscelleanous", 1)
                ,(?, "price", "Price", 1)
                ,(?, "bugs", "Problems/Bugs", 1)
                ,(?, "suggestions", "Suggestions", 1)
            ', array($company_id, $company_id, $company_id, $company_id, $company_id, $company_id) );
            
            $hosted_settings_data['companyId']            = $company_id;
            $hosted_settings_data['theme_name']           = 'Timeline';
            $hosted_settings_data['header_text']          = 'What some of our customers have to say';
            $hosted_settings_data['submit_form_text']     = 'Share your feedback with us';
            $hosted_settings_data['submit_form_question'] = 'What do you think about us?';
            $hosted_settings_data['background_image']     = '';
            DB::table('HostedSettings')->insert( $hosted_settings_data );
            
            
            $form = new FormWidget;
            $form->make_default = True;
            
            $form_data = (object) Array(
                'widgetkey'   => False
              , 'widget_type' => 'submit'
              , 'site_id'     => $site_id 
              , 'company_id' => $company_id
              , 'theme_type' => 'form-aglow'
              , 'theme_name' => "$company Default"
              , 'embed_type' => 'form'
              , 'submit_form_text'     => 'Please give us your feedback'
              , 'submit_form_question' => 'What are your thoughts about our product/services?'
              , 'tab_pos'  => 'side'
              , 'tab_type' => 'tab-l-aglow'
            );

            $form->set_widgetdata($form_data);
            $form->save();
            
            
            
            // old account creation codes.
            // $encrypt = new Encryption();
            // $password_string = $form_data->get('password');
            // $password = crypt( $password_string );
            // $name = $this->escape( $form_data->get('first_name') . ' ' . $form_data->get('last_name') );
            // $email = $this->escape( $form_data->get('email') );
            // $encrypt_string = $encrypt->encrypt($email."|".$password_string);
            // $company = $this->escape(strtolower( $form_data->get('company') ));
            // $username = $this->escape( $form_data->get('username') );
            // //$fullName = $this->escape( $form_data->get('first_name') . ' ' . $form_data->get('last_name') );
            // $firstname = $this->escape( $form_data->get('first_name') );
            // $lastname = $this->escape( $form_data->get('last_name') );
            // $site = $this->escape('www.' . $form_data->get('site_name') . '.com');
            // $site_name = $this->escape(strtolower( $form_data->get('site_name') ));
            // $plan = new DBPlan($form_data->get('plan'));
            // $plan_id = $plan->get_plan_id();
            
            // $billing_name = $form_data->get('billing_first_name') . ' ' . $form_data->get('billing_last_name');
            // $billing_address = $form_data->get('billing_address');
            // $billing_city = $form_data->get('billing_city');
            // $billing_state = $form_data->get('billing_state');
            // $billing_country = $form_data->get('billing_country');
            // $billing_zip = $form_data->get('billing_zip');
            // $bill_to = "$company, $billing_name, $billing_address, $billing_city, $billing_state, $billing_country, $billing_zip"; 

            
            // if($this->company($company)) {
                
            //     // remove this shit later.
            //     throw new Exception("The company $company already exists.");

            // } else {
                
            //     $this->dbh->beginTransaction();
            //     $this->dbh->query('
            //         INSERT INTO Company (`name`, `planId`, `billTo`, `bt_customer_id`) 
            //         VALUES("'.$site_name.'", ' . $plan_id . ', "'.$bill_to.'", "' . $bt_customer_id . '")
            //     ');
            //     $this->dbh->query('SET @company_id = LAST_INSERT_ID()');
            //     $this->dbh->query('
            //         INSERT INTO Metric (`companyId`, `totalRequest`, `totalResponse`) 
            //         VALUES(@company_id, 0, 0)
            //     '); 
            //     $this->dbh->query('
            //         INSERT INTO Site (`companyId`, `domain`, `name`, `defaultFormId`) 
            //         VALUES(@company_id, "'.$site.'", "'.$site_name.'", 1)
            //     ');
            //     $this->dbh->query('SET @site_id = LAST_INSERT_ID()');
            //     $this->dbh->query('
            //         INSERT INTO User (`companyId`, `username`, `firstname`, `lastname`, `account_owner`,`confirmed`, `password`, `encryptString`, `email`, `title`, `imId`)  
            //         VALUES (@company_id, "'.$username.'", "' . $firstname . '", "' . $lastname . '", 1, 1, "'.$password.'", "'.$encrypt_string.'", "'.$email.'", "CEO", 1)
            //     ');
            //     $this->dbh->query('SET @user_id = LAST_INSERT_ID()');
            //     $this->dbh->query('INSERT INTO AuthAssignment (`itemname`, `userid`) VALUES ("Admin", @user_id)');
            //     $this->dbh->query('
            //         INSERT INTO Category (`companyId`, `intName`, `name`, `changeable`) 
            //         VALUES
            //         (@company_id, "default", "Inbox", 0) 
            //         , (@company_id, "general", "General", 1)
            //         , (@company_id, "misc", "Miscelleanous", 1)
            //         , (@company_id, "price", "Price", 1)
            //         , (@company_id, "bugs", "Problems/Bugs", 1)
            //         , (@company_id, "suggestions", "Suggestions", 1)
            //     ');
            //     $this->dbh->query('
            //         INSERT INTO HostedSettings (`companyId`, `theme_name`, `header_text`, `submit_form_text`, `submit_form_question`, `background_image`) 
            //         VALUES (@company_id, "Timeline", "What some of our customers have to say", "Share your feedback with us", "What do you think about us?", "");
            //     ');
            //     $this->dbh->commit();

                
            //     $company_info = $this->company($site_name);
            //     $site_id = $company_info->siteid;
            //     $company_id = $company_info->companyid;
                
            //     $form = new FormWidget;
            //     $form->make_default = True;
                
            //     $form_data = (object) Array(
            //         'widgetkey'   => False
            //       , 'widget_type' => 'submit'
            //       , 'site_id'     => $site_id 
            //       , 'company_id' => $company_id
            //       , 'theme_type' => 'form-aglow'
            //       , 'theme_name' => "$company Default"
            //       , 'embed_type' => 'form'
            //       , 'submit_form_text'     => 'Please give us your feedback'
            //       , 'submit_form_question' => 'What are your thoughts about our product/services?'
            //       , 'tab_pos'  => 'side'
            //       , 'tab_type' => 'tab-l-aglow'
            //     );

            //     $form->set_widgetdata($form_data);
            //     $form->save();
                
            // }
            
        }

        public function company($company) {
            $sql = "
                select  
                    Company.companyId,
                    Site.siteId,
                    Site.name
                from 
                    Company 
                inner join
                    Site
                        on Site.companyId = Company.companyId
                where 1=1
                    and Company.name = :company_name
            ";
            $sth = $this->dbh->prepare($sql);
            $sth->bindparam(':company_name', $company);
            $sth->execute(); 
            $result = $sth->fetch(PDO::FETCH_OBJ);
            return $result;
        }

        public function companies_wo_defaultwidgets() {
            $sql = "
                SELECT 
                * 
                FROM 
                    Company
                INNER JOIN
                    Site 
                        ON Site.companyId = Company.companyId
            ";
            $sth = $this->dbh->prepare($sql); 
            $sth->execute(); 
            $result = $sth->fetchAll(PDO::FETCH_CLASS);
            return $result; 
        }

        public function activate_defaultwidgets() {
            $accounts = $this->companies_wo_defaultwidgets();
            foreach($accounts as $account) {
                
                $form = new FormWidget;
                $form->make_default = True;

                $form_data = (object) Array(
                    'widgetkey'   => False
                  , 'widget_type' => 'submit'
                  , 'site_id'     => $account->siteid 
                  , 'company_id' => $account->companyid
                  , 'theme_type' => 'form-aglow'
                  , 'theme_name' => "$account->name Default"
                  , 'embed_type' => 'form'
                  , 'submit_form_text'     => 'Please gives us your feedback'
                  , 'submit_form_question' => 'What are your thoughts about our product/services?'
                  , 'tab_pos'  => 'side'
                  , 'tab_type' => 'tab-l-aglow'
                );
               
                $form->set_widgetdata($form_data);
                $form->save();
            }

        }
    }
