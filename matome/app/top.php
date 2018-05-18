<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

//変数の宣言
//もし$_GET["keyword"]の値が空の場合は表示しない。
$keyword = !empty($_GET["keyword"]) ? $_GET["keyword"] : "";

session_start();
 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>かごゆめ</title>
    <meta http-equiv="content-type" charset="utf-8">
  </head>
  <body>
    <h1>かごゆめ</h1>
    <p>
      ショッピングサイトを使っている時、こんな経験ありませんか？<br>
     「あれいいな」<br>
     「これいいな」<br>
     「20%オフセールだって！？買わなきゃ！」...<br><br>

     そしていざ『買い物かご』を開いたとき、その合計金額に愕然とします。<br>
     「こんなに買ってたのか・・・しょうがない。いくつか減らそう・・・」<br><br>

     仕方がありません。無駄遣いは厳禁です。<br>
     でも、一度買うと決めたものを諦めるなんて、ストレスじゃあありませんか？<br>
     できればお金の事なんか考えずに好きなだけ買い物がしたい・・・。<br><br>

     このサービスは、そんなフラストレーションを解消するために生まれた、<br><br>

     『金銭取引が絶対に発生しない』<br>
     『いくらでも、どんなものでも購入できる(気分になれる)』<br>
     『ECサイト』<br><br>

     です。<br>
    </p>
    <p><?php echo login_hello(); ?></p>
    <h2>商品検索</h2>
    <p>
      <form action="<?php echo SEARCH ?>" method="GET">
        <!--検索キーワードをエンコードして渡す-->
      <input type="text" name="keyword" value="<?php echo h($keyword); ?>"/>
      <input type="submit" name="btnSubmit" value="yahooショッピングで検索する">
      </form>
      <br><br>
    </p>
    <a href="<?php echo REGISTRATION; ?>">新規登録</a>
    <?php  echo return_login();?>
    <a href="<?php echo MY_DATA; ?>">会員情報</a>
    <a href="<?php echo CART; ?>">カートの中身を確認する</a>
  </body>
</html>
