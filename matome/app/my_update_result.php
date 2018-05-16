<?php require_once '../common/scriptUtil.php'; ?>
<?php require_once '../common/dbaccesUtil.php'; ?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
      <title>会員情報更新結果画面</title>
</head>
    <body>
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
        <h1>会員情報更新結果画面</h1><br>
        名前:<?php echo $name;?><br>
        パスワード:<?php echo $password;?><br>
        メールアドレス:<?php echo $mail;?><br>
        住所:<?php echo $address;?><br><br>
        以上の内容で更新しました。<br>
        <?php
        }else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
        }
    }
    echo return_top();
    ?>
    </body>
</html>
