<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");
require_once("../common/dbaccesUtil.php");

session_start();

//もしログインしていなければログインページへ
if(!isset($_SESSION['name'])){
   echo "会員情報を確認するためにはログインが必要です。".'<br>';
   echo '<a href="./login.php">ログイン</a>';
   exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>会員情報</title>
</head>
    <body>
    <?php
       //UserIDを受け取る
        $UserID = $_SESSION['user_id'];
       //UserIDでレコードを検索
        $result = serch_profiles($UserID);
        //エラーが発生しなければ表示を行う
        if(!empty($result)){
          foreach($result as $hit){
          //セッションに記録させる
          $_SESSION['name']=$hit['name'];
          $_SESSION['password']=$hit['password'];
          $_SESSION['mail']=$hit['mail'];
          $_SESSION['address']=$hit['address'];

        ?>
        <h2>会員情報</h2><br>
        名前:<?php echo $hit['name'];?><br>
        パスワード:<?php echo $hit['password'];?><br>
        メールアドレス:<?php echo $hit['mail'];?><br>
        住所:<?php echo $hit['address'];?><br>
        <?php
        }}else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
        }?>
        <a href="<?php echo MY_HISTORY;?>">購入履歴</a>
        <a href="<?php echo MY_UPDATE;?>">会員情報更新</a>
        <a href="<?php echo MY_DELETE;?>">退会する</a>
     <?php  echo return_top();?>
    </body>
</html>
