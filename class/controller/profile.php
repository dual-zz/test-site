<?php

require_once './class/database/config.php';

require_once './class/model/profile.php';
require_once './class/view/profile.php';

/**
 * Profile controller
 */
class Profile_Controller {
   
   public function run()
   {
      static $data;
      try
      {
         $model = new Profile_Model;
         $view  = new Profile_View;
         
         $profile_id = $_GET['id'];
         
         $data['profile_id'] = $profile_id;
         $data['online']     = $model->auth_check();
         $data['edit']       = $model->edit;
         $data['do_edit']    = $model->do_edit;
         $data['user']       = $model->initUser();
         $data['can_edit']   = $model->can_edit_check($data['user'],$profile_id);
         
         if ($data['do_edit'])
         {
            if (!$data['can_edit'])
            {
                throw new siteException("Недостаточно прав.");
            }
            else if ($data['can_edit'])
            {
                $model->update_user_data($profile_id);
                header("Location: ./id".$profile_id);
                die();
            }
         }
         else
         {
            if ($data['edit'] && (!$data['can_edit']))
            {
                header("Location: ./id".$profile_id);//.$_SERVER['REDIRECT_URL']);
                die();
            }
            else if ($data['edit'] && $data['can_edit'])
            {
               $data['user_info'] = $model->get_user_info($profile_id);
               $view->print_profile_edit($data);
            }
            else 
            {
               $data['user_info'] = $model->get_user_info($profile_id);
               $data['edit_link'] = './id'.$profile_id.'?edit';
               $view->print_profile($data);
            }
         }
      }
      catch (siteException $ee)
      {
         $data['error'] = $ee->getMessage();
         $view->print_error($data);
      }
      catch (PDOException $ee)
      {
         $data['error'] = $ee->getMessage();
         $view->print_error($data);
      }
   }
}//END

?>