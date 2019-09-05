<!DOCTYPE html>
<html>
<head>
	<title>
	MISSION 5
	</title>
	<meta charset="utf-8">
</head>
<body>
<h1>test page</h1>
<?php
$dsn = 'mysql:dbname=tb*******db; host=localhost';
$user = 'tb-******';
$password = 'PASSWORD';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

if (isset($_POST["osu"]) && $_POST["confirm"] == "" && $_POST["password"] !== "") {
  echo "今回のコメント結果：";
  if($_POST["comment"] == ""){
  	echo("空白のコメントです。<br><br>");
  }
  else{
    echo($_POST["comment"]."を受け付けました<br><br>");
    $sql = "CREATE TABLE IF NOT EXISTS commenttest
          (
          id INT AUTO_INCREMENT PRIMARY KEY,
          Name VARCHAR(32) NOT NULL,
          Comment VARCHAR(255) NOT NULL,
          CMtime timestamp,
          CMpassword VARCHAR(32) NOT NULL
          )";
    $stmt = $pdo->query($sql);

    $name = $_POST["name"];
    $cm = $_POST["comment"];
    $pw = $_POST["password"];
    $sql =  "INSERT INTO commenttest(Name,Comment,CMtime,CMpassword) VALUES ('$name','$cm',CURRENT_TIMESTAMP,'$pw')";
    $stmt = $pdo->query($sql);
  }

}

if (isset($_POST["delete"])) {
  $deletenum = $_POST["deletenum"];
  $deletepass = $_POST["deletepass"];
  $sql = "SELECT CMpassword FROM commenttest WHERE id = $deletenum";
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchall();
  foreach ($results as $row){
    $pass = $row['CMpassword'];
  }
  if ($deletepass === $pass){
    $sql = "DELETE FROM commenttest WHERE id = '$deletenum'";
    $stmt = $pdo->query($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
  else{
  //    echo $deletepass." ";
  //    echo $pass;
      echo "正確なパスワードを入力してください";
      }
}

//編集機能（元内容確定）
if (isset($_POST["edit"])) {
  $editnum = $_POST["editnum"];
  $editpass = $_POST["editpass"];
  $sql = "SELECT * FROM commenttest WHERE id = '$editnum'";
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchall();
  foreach ($results as $row){
    $pass = $row['CMpassword'];
    $editcomment = $row['Comment'];
    $editname = $row['Name'];
    $editnum = $row['id'];
  }
}  
//編集機能
if(isset($_POST["osu"]) && $_POST["confirm"] !== ""){
  $pass = $_POST["confirm"];
  $editnum = $_POST["confirm"];
  $name = $_POST["name"];
  $cm = $_POST["comment"];
  $pw = $_POST["password"];
  if($pw = $pass){
    $sql = "UPDATE commenttest SET Name='$name',Comment='$cm',CMtime=CURRENT_TIMESTAMP WHERE id='$editnum'";
    $stmt = $pdo->query($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
}
?>

<form action = "mission_5.php" method = "POST">  
<input type = "hidden" name="confirm" value="<?php if(isset($editcomment)) {echo $editnum;} ?>"></br>
コメントの内容を入力してください</br><input type = "text" name="comment" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>"></br>
お名前を入力してください</br><input type = "text" name ="name" value ="<?php if(isset($editname)) {echo $editname;} ?>"/></br>
パスワードを入力してください</br><input type = "text" name ="password"/></br>
<input type="submit" name="osu" value="コメント"/></br>
削除したいコメントの番号を入力してください</br><input type = "text" name ="deletenum"/></br>
パスワードを入力してください</br><input type = "text" name ="deletepass"/></br>
<input type="submit" name="delete" value="削除"/></br>
編集したいコメントの番号を入力してください</br><input type = "text" name ="editnum"/></br>
パスワードを入力してください</br><input type = "text" name ="editpass"/></br>
<input type="submit" name="edit" value="編集"/></br>
</form>
</br>
テストするため、パスワードも見られるように設置しました</br>
<?php
$sql = 'SELECT * FROM commenttest';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
    echo "番号：".$row['id'].'<br>';
    echo "ユーザー：".$row['Name'].'<br>';
    echo "内容：".$row['Comment'].'<br>';
    echo "時間：".$row['CMtime'].'<br>';
    echo "パスワード：".$row['CMpassword'].'<br>';
  echo "<hr>";
}
?>
</body>
</html>