<?php require_once '../common/scriptUtil.php'; ?>
<?php require_once '../common/dbaccesUtil.php'; ?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
      <title>会員情報更新結果画面</title>
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
    if(!$_POST['mode']=="RESULT"){
        echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
    }else{

        session_start();
        $name=$_POST['name'];
        $password=$_POST['password'];
        $mail=$_POST['mail'];
        $address=$_POST['address'];
        $UserID=$_SESSION['user_id'];

        //データのDB挿入処理。エラーの場合のみエラー文がセットされる。成功すればnull
        $result = update_profile($name, $password, $mail, $address,$UserID);

        //エラーが発生しなければ表示を行う
        if(!isset($result)){
        ?>
        <legend>会員情報更新結果画面</legend><br>
        <p>名前：<?php echo $name;?><br></p>
        <p>パスワード：<?php echo $password;?><br></p>
        <p>メールアドレス：<?php echo $mail;?><br></p>
        <p>住所：<?php echo $address;?><br><br></p>
        <p>以上の内容で更新しました。<br></p>
        <?php
        }else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
        }
    }
    ?>
    </body>
</html>
