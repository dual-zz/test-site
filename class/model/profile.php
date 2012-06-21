<?php

require_once './class/model/site.php';

/**
 * Login model
 */
class Profile_Model extends Site_Model {
   
   public $edit;
   public $do_edit;
   
   private $name;
   private $city;
   private $age;
   private $about;
   private $avatar;
   
   function __construct()
   {
      $this->edit    = (isset($_GET['edit'])) ? TRUE : FALSE;
      $this->do_edit = (isset($_POST['do_edit'])) ? TRUE : FALSE;
   }
   
   /**
    * check of possibility of editing
    *
    * @return bool
    */
   function can_edit_check($user,$profile_id) 
   {
      if (!$profile_id || !isset($profile_id))
      {
         header("Location: ./id".$user['id']);
      }
      else if ($user['rights'] == 1)
      {
         return TRUE;
      }
      else if ($user['id'] == $profile_id)
      {
         return TRUE;
      }
      else 
      {
         return FALSE;
      }
   }
   
   /**
    * get_user_info
    *
    * @return array
    */
   function get_user_info($id) 
   {
      try
      {
         $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,eval(PDO_UTF));
         $STH = $DBH->prepare("SELECT * FROM `user_info` WHERE id = :id");
         $STH->bindValue(':id',$id);
         $STH->execute();
         SQL_Error($STH);
         
         if (!$STH->rowCount())
         {
            $STH1 = $DBH->prepare("SELECT * FROM `user` WHERE id = :id");
            $STH1->bindValue(':id',$id);
            $STH1->execute();
            SQL_Error($STH1);
            
            if (!$STH1->rowCount())
            {
               throw new siteException("Error: не найдено соответствие по id.");
            }
            else if ($STH1->rowCount() == 1)
            {
               $STH2 = $DBH->prepare("INSERT INTO `user_info` (id) VALUES (:id)");
               $STH2->bindValue(':id',$id);
               $STH2->execute();
               SQL_Error($STH2);
               
               $user_info = $this->get_user_info($id);
               return $user_info;
            }
            else
            {
               throw new siteException('Произошла ошибка номер 666. Обратитесь к админестратору.');
            }
         }
         else if ($STH->rowCount() == 1)
         {
            $user_info = $STH->fetch();
            return $user_info;
         }
         else
         {
            throw new siteException('Произошла ошибка номер 666. Обратитесь к админестратору.');
         }
      }
      catch (PDOException $e)
      {
         throw new siteException($e->getMessage());
      }
   }

   /**
    * Update data into user_info
    */
   public function update_user_data($profile_id)
   {
      try
      {
         if (isset($_FILES['avatar']))
         {
            $max_image_size   = 1024 * 1024;
            $valid_types   = array("gif", "jpg", "png", "jpeg");
               
            if (is_uploaded_file($_FILES['avatar']['tmp_name']))
            {
               $filename = $_FILES['avatar']['tmp_name'];
               $ext = strtolower(substr($_FILES['avatar']['name'], 1 + strrpos($_FILES['avatar']['name'], ".")));
                  
               if (filesize($filename) > $max_image_size)
               {
                  throw new siteException('Error: автар должен быть меньше 1Mб.');
               }
               else if (!in_array($ext, $valid_types))
               {
                  throw new siteException('Error: недопустимое расширение автара.');
               }
               else 
               {
                  $size = GetImageSize($filename);
                  if ($size)
                  {
                     $dir = "/home/site/www/user/avatar/";  
                     if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dir.$profile_id.'.'.$ext))
                     {
                        $this->avatar = './user/avatar/'.$profile_id.'.'.$ext;
                     }
                     else
                     {
                        throw new siteException('Error: moving file failed. обратитесь к администратору.');
                     }
                  }
                  else
                  {
                     throw new siteException('Error: invalid image properties. обратитесь к администратору.');
                  }
               }
            }
            else
            {
               ;//throw new siteException('Error: empty file.');
            }
         }
      
         $this->name  = $_POST['name']; 
         $this->city  = $_POST['city'];
         $this->age   = $_POST['age'];
         $this->about = $_POST['about'];
         
         $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,eval(PDO_UTF));
         
         if ($this->avatar)
         {
            $STH = $DBH->prepare("UPDATE `user_info` SET 
                                                      `name`   = :name,
                                                      `city`   = :city,
                                                      `age`    = :age,
                                                      `about`  = :about,
                                                      `avatar` = :avatar WHERE id = :id");
            $STH->bindValue(':avatar',$this->avatar);
         }
         else 
         {
            $STH = $DBH->prepare("UPDATE `user_info` SET 
                                                      `name`   = :name,
                                                      `city`   = :city,
                                                      `age`    = :age,
                                                      `about`  = :about WHERE id = :id");
         }
         
         $STH->bindValue(':name',$this->name);
         $STH->bindValue(':city',$this->city);
         $STH->bindValue(':age',$this->age);
         $STH->bindValue(':about',$this->about);
         $STH->bindValue(':id',$profile_id);
         $STH->execute();
         SQL_Error($STH);
      }
      catch (PDOException $e)
      {
         throw new siteException($e->getMessage());
         
      }
   }
}//END
?>