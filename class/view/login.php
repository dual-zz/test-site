<?php

/**
 * Login view
 */
class login_view {
   
   function __construct()
   {
      ;
   }
   
   public function print_login()
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_out.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/login.htm");
      include("./html/pattern/footer.htm");
   }
}

?>