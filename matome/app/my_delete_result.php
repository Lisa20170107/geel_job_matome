<?php require_once '../common/scriptUtil.php';
      require_once '../common/dbaccesUtil.php';

      session_start();

//もしログインしていなければログインページへ
if(!isset($_SESSION['name'])){
   echo "アクセスが不正です。トップページからお戻りください。".'<br>';
   echo return_top();
}
 ?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
      <title>退会画面</title>
</head>
    <body>
    <?php
        //UserIDを受け取る
        $UserID=$_SESSION['user_id'];

        //データのDB挿入処理。エラーの場合のみエラー文がセットされる。成功すればnull
        $result = delete_profile($UserID);

        //エラーが発生しなければ表示を行う
        if(!isset($result)){
        //全てのセッションを破棄する。
        $_SESSION = array();
        session_destroy();
        ?>
        <h1>退会画面</h1><br>
        <p>退会しました</p>
        <?php
        }else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
        }
    echo return_top();
    ?>
    </body>
</html>
