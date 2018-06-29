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
    //もしも以前退会していたら新規登録画面へ
    if($value['deleteFlg']==1){
      echo "退会されています。新しく登録してください。";
      echo '<a href="./REGISTRATION.php">新規登録</a>';
      exit;
    }

    $_SESSION['name'] =$value['name'];
    //注文記録用
    $_SESSION['user_id'] =$value['UserID'];
    echo $_SESSION['name']."さん。ログインが完了しました。";

    //ログインが完了すると、直前のページにジャンプする。
    if($before_url){
      header("Location: $before_url");
    exit;
    }
  }
}
// ログインしている状態ならログアオウトしてtop.phpへ
if(isset($_SESSION['name'])){
  //全てのセッションを破棄
  $_SESSION = array();
  session_destroy();
  header("Location: top.php");
  exit;
}

else {
  // ログイン情報の入力が無いので、ログインページへの初回アクセス
  // REFERERをセッションに格納しておく
  $_SESSION['before_url'] = $_SERVER['HTTP_REFERER'];
?>
 <html>
   <head>
     <title>ログインサンプル</title>
     <meta http-equiv="content-type" charset="utf-8">
     <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
     <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
   </head>
   <body>
   <legend>Login</legend>
   <div class="w-25 p-3 mx-auto"><div class="form-group">
   <form action="./login.php" method="post">
      <label for="exampleInputEmail1">name</label>
      <input type="text" name="name" class="form-control" placeholder="Enter name"><br>
      <label for="exampleInputEmail1">password</label>
      <input type="text" name="password" class="form-control" placeholder="Enter password">
      <br>
      <button type="submit" class="btn btn-primary" name='login' value="ログイン">ログイン</button>
   </form>
    </div>
    </div>
    <?php }?>
    <a href="<?php echo REGISTRATION; ?>">新規登録</a>
    <?php echo return_top();?>
    </body>
 </html>
