<?php require_once '../common/defineUtil.php'; ?>
<?php require_once '../common/scriptUtil.php'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>会員情報更新</title>
      <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
      <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
</head>
<body>
  <ol class="breadcrumb fixed-top">
    <li class="breadcrumb-item"><?php  echo return_top();?></li>
    <li class="breadcrumb-item"><a href="<?php echo MY_DATA; ?>">会員情報</a></li>
    <li class="breadcrumb-item"><a href="<?php echo CART; ?>">カートの中身を確認する</a></li>
  </ol>
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
    <legend>会員情報更新</legend>
    <div class="w-25 p-3 mx-auto"><div class="form-group">
    <form action="<?php echo MY_UPDATE_RESULT ?>" method="POST">

      <label for="exampleInputEmail1">名前</label>
      <input type="text" name="name" class="form-control" value=<?php echo $text; ?>>
      <br>


      <label for="exampleInputEmail1">パスワード</label>
      <input type="text" name="password" class="form-control" value=<?php echo $password; ?>>
      <br>

      <label for="exampleInputEmail1">メールアドレス</label>
      <input type="text" name="mail" class="form-control" value=<?php echo $mail; ?>>
      <br>

      <label for="exampleInputEmail1">住所</label>
      <textarea name="address" rows=10 cols=50 style="resize:none" wrap="hard" class="form-control"><?php echo $address; ?></textarea>
      <br>
     <p>以上の内容で更新しますか?</p>
        <input type="hidden" name="mode"  value="RESULT">
        <button type="submit" class="btn btn-primary" name="btnSubmit" value="更新する">更新する</button>
    </form>
  </div>
</div><br>
</body>
</html>
