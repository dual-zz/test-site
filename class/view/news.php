<?php

/**
 * News view
 */
class news_view {
	
	function __construct()
	{
		;
	}
   
   public function print_in()
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_in.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/news.htm");
      include("./html/pattern/footer.htm");
   }
   
   public function print_out()
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_out.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/news.htm");
      include("./html/pattern/footer.htm");
   }
}

?>