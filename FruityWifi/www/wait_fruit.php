<?
if ($page == "") {
	$page = "./page_status.php";
}

if ($wait == "") {
	$wait = 2;
}

?>
<script type="text/javascript">
<!--
function delayer(){
    window.location = "<?=$page?>"
}
//-->
</script>
<pre><? 
$fruit_num = rand(1, 6);
if ($fruit_num == 1) {
?><font style="color:green">
       .~~.   .~~.
      '. \ ' ' / .' </font><font style="color:red">
       .~ .~~~..~.
      : .~.'~'.~. :
     ~ (   ) (   ) ~
    ( : '~'.~.'~' : )
     ~ .~ (   ) ~. ~
      (  : '~' :  ) </font><font style="color:white">Evil Pi</font><font style="color:red">
       '~ .~~~. ~'
           '~'
</font>
<? } else if ($fruit_num == 2) { ?>
<font style="color:yellow">
  _
 //\
 V  \
  \  \_
   \,'.`-.
    |\ `. `.       
    ( \  `. `-.                        _,.-:\
     \ \   `.  `-._             __..--' ,-';/
      \ `.   `-.   `-..___..---'   _.--' ,'/
       `. `.    `-._        __..--'    ,' /
         `. `-_     ``--..''       _.-' ,'
           `-_ `-.___        __,--'   ,'
              `-.__  `----"""    __.-'
                   `--..____..--' 

</font>
<? } else if ($fruit_num == 2) { ?>
<font style="color:green">
           __
       __ {_/ 
       \_}\\ </font><font style="color:purple">_
          _\(_)_
         (_)_)(_)_
        (_)(_)_)(_)
         (_)(_))_)
          (_(_(_)
           (_)_)
            (_)
</font>
<? } else if ($fruit_num == 3) { ?>
<font style="color:green">
         \VW/ </font><font style="color:red">
       .::::::.
       ::::::::
       '::::::'
        '::::'
          `"`
</font>
<? } else if ($fruit_num == 4) { ?>
<font style="color:green">
       __.--~~.,-.__
       `~-._.-(`-.__`-.
               \    `~~` </font><font style="color:red">
          .--./ \
         /#   \  \.--.
         \    /  /#   \
          '--'   \    /
                  '--'
</font>
<? } else if ($fruit_num == 5) { ?>
</font><font style="color:green">
           ______
       .-'' ____ ''-.
      /.-=""    ""=-.\
      |-===wwwwww===-|
      \'-=,,____,,=-'/
       '-..______..-'
</font>
<? } else if ($fruit_num == 6) { ?>
</font><font style="color:orange">
            __ __
         ,-':.x.;`-.
       ,;;;`,:,,: .;`.
      /;;;;.: ,.:. : '\
     |;;;;;.`'.:,;`. : ;
     |;;;; ;,` `' ` .',;
     |;;;;`.:`.:,`, ., ;
      \;;;;,`:.::, .: /
       `:;;;;::,:,::,'
         `-;;_,_..-' 

</font>
<? } ?>

</pre>
<script>setTimeout('delayer()', <?=(1000 * $wait)?>)</script>
</body>