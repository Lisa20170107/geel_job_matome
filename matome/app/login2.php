<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");
require_once("../common/dbaccesUtil.php");

//エラーの表示をさせなくする
error_reporting(E_ALL & ~E_NOTICE);

// セッション開始
session_start();

// ログイン情報が送られてきているときは、ログイン処理
if (isset($_POST['name']) && isset($_POST['password'])) {
  //ログイン
  //フォームの値をlogin_profiles();に渡し、レコードを検索する。フォームの値と一致したレコードを配列で取得する。
  $result = login_profiles($_POST['name'],$_POST['password']);
  // セッションから前ページのURLを取り出す
  $before_url = $_SESSION['before_url'];
  //配列の中の名前の値を繰り返し文で取り出す
  foreach($result as $value){

    $_SESSION['name'] =$value['name'];
    echo $_SESSION['name']."さん。ログインが完了しました。";

    //ログインが完了すると、直前のページにジャンプする。
    if($before_url){
      header("Location: $before_url");
    exit;
    }
  }
} else {
  // ログイン情報の入力が無いので、ログインページへの初回アクセス
  // REFERERをセッションに格納しておく
  $_SESSION['before_url'] = $_SERVER['HTTP_REFERER'];
?>
 <html>
   <head>
     <title>ログインサンプル</title>
     <meta http-equiv="content-type" charset="utf-8">
   </head>
   <body>
    <p><font size ="3px" color="#008080">ログイン</font></p>
      <form action="./login.php" method="post">
       <!-- formタグで括られた入力項目はこれら -->
        <p>名前：<input type="text" name="name"></p>
        <p>パスワード：<input type="text" name="password"></p>
        <input type="submit" name='login' value="ログイン">
      </form>
    <?php }?>
    </body>
 </html>
