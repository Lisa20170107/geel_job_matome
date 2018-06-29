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
      <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
      <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
</head>
    <body>
      <ol class="breadcrumb fixed-top">
        <li class="breadcrumb-item"><a href="<?php echo REGISTRATION; ?>">新規登録</a></li>
        <li class="breadcrumb-item active"><?php echo return_top();?></li>
      </ol>
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
    ?>
    </body>
</html>
