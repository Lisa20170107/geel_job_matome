<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");
require_once("../common/dbaccesUtil.php");

session_start();

//もしログインしていなければログインページへ
if(!isset($_SESSION['name'])){
   echo "不正なアクセスです。トップページにお戻りください。".'<br>';
   echo  return_top();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>会員情報</title>
      <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
      <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
</head>
    <body>
      <ol class="breadcrumb fixed-top">
        <li class="breadcrumb-item"><a href="<?php echo REGISTRATION; ?>">新規登録</a></li>
        <li class="breadcrumb-item active"><?php  echo return_login();?></li>
        <li class="breadcrumb-item"><a href="<?php echo MY_DATA; ?>">会員情報</a></li>
        <li class="breadcrumb-item"><a href="<?php echo CART; ?>">カートの中身を確認する</a></li>
      </ol>
    <?php
       //UserIDを受け取る
        $UserID = $_SESSION['user_id'];
       //UserIDでレコードを検索
        $result = serch_profiles($UserID);
        //エラーが発生しなければ表示を行う
        if(!empty($result)){
          foreach($result as $hit){
        ?>
        <h2>会員情報</h2><br>
        <p>名前：<?php echo $hit['name'];?></p><br>
        <p>パスワード：<?php echo $hit['password'];?></p><br>
        <p>メールアドレス：<?php echo $hit['mail'];?></p><br>
        <p>住所：<?php echo $hit['address'];?></p><br>
        <?php
        }}else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
        }?>
     <p>本当に退会しますか？（情報が全て削除されます）</p><br>
     <a class="btn btn-warning" href="<?php echo MY_DELETE_RESULT;?>">はい</a>
     <a class="btn btn-primary" href="<?php echo TOP_URL;?>">いいえ</a><br>
    </body>
</html>
