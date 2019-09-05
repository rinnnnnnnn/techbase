<!DOCTYPE html>
<html>
<head>
	<title>
	MISSION 3-5
	</title>
	<meta charset="utf-8">
</head>
<body>
<h1>test page</h1>
<?php
if (isset($_POST["osu"]) && $_POST["confirm"] == "" && $_POST["password"] !== "") {
  echo "今回のコメント結果：";
  if($_POST["comment"] == ""){
  	echo("空白のコメントです。<br><br>");
  }
  else{
    echo($_POST["comment"]."を受け付けました<br><br>");
    $filename = "mission_3-5.txt";
    $timestamp = time();
    $fp = fopen($filename,"a");
    date_default_timezone_set("Asia/Tokyo");
      if(filesize($filename) == 0){    
        $num = 1;
        fwrite($fp,$num. "<>". $_POST["name"]. "<>". $_POST["comment"]. "<>". date( "Y/m/d a h:m:s", $timestamp ). "<>".$_POST["password"]. "<>"."\r\n");    
        fclose($fp);
      }
      else{
        $file = file($filename);
        $last = $file[count($file)-1];
        $contentarray = explode("<>",$last);
        $num = array_shift($contentarray);
        $num ++;
        fwrite($fp,$num. "<>". $_POST["name"]. "<>". $_POST["comment"]. "<>". date( "Y/m/d a h:i:s", $timestamp ). "<>".$_POST["password"]. "<>". "\r\n");    
        fclose($fp);
      }    
    
  }
}
//削除機能
if (isset($_POST["delete"])) {
  $filename = "mission_3-5.txt";
  $fileCont = file($filename);
  $deletenum = $_POST["deletenum"];
  $fp = fopen($filename,"w");
  foreach ($fileCont as $row) {
    $arr = explode("<>", $row);
    $password = $arr[4];
        if($deletenum !== $arr[0]){
        fwrite($fp,$row);  
        }
        else{
          if($_POST["deletepass"] !== $password){
            echo "正確なパスワードを入力してください";
            fwrite($fp,$row);  
          }
        }
     }
      fclose($fp);
      unset($row);
}
//編集機能（元内容確定）
if (isset($_POST["edit"])) {
  $filename = "mission_3-5.txt";
  $fileCont = file($filename);
  $editnum = $_POST["editnum"];
  foreach ($fileCont as $row) {
        $arr = explode("<>", $row);
        if($editnum == $arr[0] && $_POST["editpass"] == $arr[4]){
          $editcomment = $arr[2];
          $editname = $arr[1];
        }
      }
      unset($row);
}    
//編集機能
if(isset($_POST["osu"]) && $_POST["confirm"] !== ""){
  $filename = "mission_3-5.txt";
  $fileCont = file($filename);
  $editnum = $_POST["confirm"];
  $timestamp = time();
  $fp = fopen($filename,"w");
  foreach ($fileCont as $row) {
    $arr = explode("<>", $row);
    $password = $arr[4];    
       if($editnum !== $arr[0]){
          fwrite($fp, $row);  
        }
        else{
          if($_POST["password"] == $password){
            fwrite($fp, $arr[0]. "<>". $_POST["name"]. "<>". $_POST["comment"]. "<>".date( "Y/m/d a h:i:s", $timestamp ). "<>". $_POST["password"]. "<>"."\r\n");
          }
        }   
  }
      fclose($fp);
      unset($row);
}
?> 

<form action = "mission_3-5.php" method = "POST">  
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
</br>    
<?php
  echo "過去のコメント<br>";
  $filename = "mission_3-5.txt";
  if(file_exists($filename) == true){
     $fileCont = file($filename);
     foreach ($fileCont as $row) {
        $arr = explode("<>", $row,-2);
        foreach ($arr as $value){
          echo $value.". ";
        }
      unset($value);
      echo "<br>";
    }
    unset($row);    
  }
?>
</body>
</html>

