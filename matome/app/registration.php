<?php require_once '../common/defineUtil.php'; ?>
<?php require_once '../common/scriptUtil.php'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>会員登録</title>
</head>
<body>
    <?php session_start();//再入力時用

    // 初期値設定
    // 名前
    if(isset ($_SESSION['name'])){
    $text=$_SESSION['name'];
    }else{
    $text="";
    }


    // password
    if(isset ($_SESSION['password'])){
    $password=$_SESSION['password'];
    }else{
    $password="";
    }

    // mail
    if(isset ($_SESSION['mail'])){
    $mail=$_SESSION['mail'];
    }else{
    $mail="";
    }

    // address
    if(isset ($_SESSION['address'])){
    $address=$_SESSION['address'];
    }else{
    $address="";
    }


    ?>
    <h2>会員登録</h2>
    <form action="<?php echo REGISTRATION_CONFIRM ?>" method="POST">

      名前:
      <input type="text" name="name" value=<?php echo $text ?>>
      <br><br>


      パスワード:
      <input type="text" name="password" value=<?php echo $password ?>>
      <br><br>

      メールアドレス:
      <input type="text" name="mail" value=<?php echo $mail ?>>
      <br><br>

      住所:<br>
      <textarea name="address" rows=10 cols=50 style="resize:none" wrap="hard"><?php echo $address ?></textarea>
      <br><br>

      <input type="hidden" name="mode"  value="CONFIRM">
      <input type="submit" name="btnSubmit" value="確認画面へ">
    </form><br>
    <?php echo return_top();?>
</body>
</html>
