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
     <p>本当に退会しますか？（情報が全て削除されます）</p><br>
     <a href="<?php echo MY_DELETE_RESULT;?>">はい</a><br>
     <a href="<?php echo TOP_URL;?>">いいえ</a><br>
    </body>
</html>
