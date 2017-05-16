class foo
{
  $functions = array(
  'function1' => function($echo) {
        echo $echo;
   },
  'function2' => function($echo) {
         echo $echo;
    },
  'function3' => function($echo) {
          echo $echo;
     },
);

call_user_func($function["function1"], array("one"));
call_user_func($function["function2"], array("two"));
call_user_func($function["function3"], array("three"));
}
