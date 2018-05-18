<?php


//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=kagoyume_db;charset=utf8','rt20180510','＊＊＊＊＊');
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

//レコードの挿入を行う。失敗した場合はエラー文を返却する
function insert_profiles($name, $password, $mail, $address){
    //db接続を確立
    $insert_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO user_t(name,password,mail,address,newDate)"
            . "VALUES(:name,:password,:mail,:address,:newDate)";

    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':name',$name);
    $insert_query->bindValue(':password',$password);
    $insert_query->bindValue(':mail',$mail);
    $insert_query->bindValue(':address',$address);
    $insert_query->bindValue(':newDate',$date);

    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }

    $insert_db=null;
    return null;
}


//フォームから受け取った値でレコードを検索、一致したレコードを返す
function login_profiles($name=null,$password=null){
    //db接続を確立
    $search_db = connect2MySQL();

    $search_sql = "SELECT * FROM user_t WHERE name = :name AND password = :password";

    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);

    $seatch_query->bindValue(':name',$name);
    $seatch_query->bindValue(':password',$password);

    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_query=null;
        return $e->getMessage();
    }

    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}


//レコードの挿入を行う。(商品)失敗した場合はエラー文を返却する
function insert_item($UserID, $itemcode, $type){
    //db接続を確立
    $insert_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO buy_t(UserID,itemcode,type,buyDate)"
            . "VALUES(:UserID,:itemCode,:type,:buyDate)";

    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':UserID',$UserID);
    $insert_query->bindValue(':itemCode',$itemcode);
    $insert_query->bindValue(':type',$type);
    $insert_query->bindValue(':buyDate',$date);

    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }

    $insert_db=null;
    return null;
}

//レコードの情報を更新する。（合計金額）失敗した場合はエラー文を返却する。
function update_item_profile($sum,$UserID){
  //db接続を確立
  $update_db = connect2MySQL();
  //DBに全項目のある1レコードを登録するSQL
  //totalが最初nullだった場合、0に置き換えてから加算する（nullに加算してもnullのまま
  $update_sql = "UPDATE user_t SET total = coalesce(total,0)+:sum WHERE UserID = :UserID";

  //クエリとして用意
  $update_query = $update_db->prepare($update_sql);

  //SQL文にセッションから受け取った値＆現在時をバインド
  $update_query->bindValue(':UserID',$UserID);
  $update_query->bindValue(':sum',$sum);


  //SQLを実行
  try{
      $update_query->execute();

  } catch (PDOException $e) {
      //接続オブジェクトを初期化することでDB接続を切断
      $update_db=null;
      return $e->getMessage();
  }

  $update_db=null;
  return null;
}

//UserIDでレコードを検索、一致したレコードを返す
function serch_profiles($UserID){
    //db接続を確立
    $search_db = connect2MySQL();

    $search_sql = "SELECT * FROM user_t WHERE UserID = :UserID";

    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);

    $seatch_query->bindValue(':UserID',$UserID);


    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_query=null;
        return $e->getMessage();
    }

    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

//UserIDで購入管理テーブルからレコードを検索、一致したレコードを返す。
function serch_item_profiles($UserID){
    //db接続を確立
    $search_db = connect2MySQL();

    $search_sql = "SELECT * FROM buy_t WHERE UserID = :UserID";

    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);

    $seatch_query->bindValue(':UserID',$UserID);


    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_query=null;
        return $e->getMessage();
    }

    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

//レコードの情報を更新する。失敗した場合はエラー文を返却する。
function update_profile($name, $password, $mail, $address,$UserID){
  //db接続を確立
  $update_db = connect2MySQL();
  //DBに全項目のある1レコードを登録するSQL
  $update_sql = "UPDATE user_t SET name = :name,password=:password,mail=:mail,address=:address,newDate=:newDate
                 WHERE UserID= :UserID";

  //現在時をdatetime型で取得
  $datetime =new DateTime();
  $date = $datetime->format('Y-m-d H:i:s');

  //クエリとして用意
  $update_query = $update_db->prepare($update_sql);

  //SQL文にセッションから受け取った値＆現在時をバインド
  $update_query->bindValue(':UserID',$UserID);
  $update_query->bindValue(':name',$name);
  $update_query->bindValue(':password',$password);
  $update_query->bindValue(':mail',$mail);
  $update_query->bindValue(':address',$address);
  $update_query->bindValue(':newDate',$date);

  //SQLを実行
  try{
      $update_query->execute();
  } catch (PDOException $e) {
      //接続オブジェクトを初期化することでDB接続を切断
      $update_db=null;
      return $e->getMessage();
  }

  $update_db=null;
  return null;
}


//会員の退会処理。会員情報の削除フラグを1に変更する。失敗した場合はエラー文を返却する。
function delete_profile($UserID){
   //削除フラグ
   $i=1;
  //db接続を確立
  $update_db = connect2MySQL();
  //DBに全項目のある1レコードを登録するSQL
  $update_sql = "UPDATE user_t SET deleteFlg = :i,newDate=:newDate
                 WHERE UserID= :UserID";

  //現在時をdatetime型で取得
  $datetime =new DateTime();
  $date = $datetime->format('Y-m-d H:i:s');

  //クエリとして用意
  $update_query = $update_db->prepare($update_sql);

  //SQL文にセッションから受け取った値＆現在時をバインド
  $update_query->bindValue(':UserID',$UserID);
  $update_query->bindValue(':i',$i);
  $update_query->bindValue(':newDate',$date);

  //SQLを実行
  try{
      $update_query->execute();
  } catch (PDOException $e) {
      //接続オブジェクトを初期化することでDB接続を切断
      $update_db=null;
      return $e->getMessage();
  }

  $update_db=null;
  return null;
}
