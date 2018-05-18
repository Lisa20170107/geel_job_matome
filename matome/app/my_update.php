<?php require_once '../common/defineUtil.php'; ?>
<?php require_once '../common/scriptUtil.php'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>会員情報更新</title>
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
    <h2>会員情報更新</h2>
    <form action="<?php echo MY_UPDATE_RESULT ?>" method="POST">

      名前:
      <input type="text" name="name" value=<?php echo $text; ?>>
      <br><br>


      パスワード:
      <input type="text" name="password" value=<?php echo $password; ?>>
      <br><br>

      メールアドレス:
      <input type="text" name="mail" value=<?php echo $mail; ?>>
      <br><br>

      住所:<br>
      <textarea name="address" rows=10 cols=50 style="resize:none" wrap="hard"><?php echo $address; ?></textarea>
      <br><br>
     <p>以上の内容で更新しますか?</p>
        <input type="hidden" name="mode"  value="RESULT">
        <input type="submit" name="btnSubmit" value="更新する">
    </form><br>
     <?php  echo return_top();?>
</body>
</html>
