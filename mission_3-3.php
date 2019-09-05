<!DOCTYPE html>
<html>
<head>
	<title>
	MISSION 3-3
	</title>
	<meta charset="utf-8">
</head>
<body>
<h1>test page</h1>
<form action = "mission_3-3.php" method = "POST">  
コメントの内容を入力してください</br><input type = "text" name ="comment"/></br>
お名前を入力してください</br><input type = "text" name ="name"/></br>
<input type="submit" name="osu" value="コメント"/></br>
削除したいコメントの番号を入力してください</br><input type = "text" name ="deletenum"/></br>
<input type="submit" name="delete" value="削除"/></br>
</form>
</br>
</br>

<?php
if (isset($_POST["osu"])) {
  echo "今回のコメント結果：";
  if($_POST["comment"] == ""){
  	echo("空白のコメントです。<br><br>");
  }
  else{
  echo($_POST["comment"]."を受け付けました<br><br>");
  $filename = "mission_3-1.txt";
  $timestamp = time();
  $fp = fopen($filename,"a");
  date_default_timezone_set("Asia/Tokyo");
  	if(filesize($filename) == 0){    
  		$num = 1;
  		fwrite($fp,$num. "<>". $_POST["name"]. "<>". $_POST["comment"]. "<>". date( "Y/m/d a h:m:s", $timestamp ). "\r\n");    
   		fclose($fp);
  	}
 	else{
  		$file = file($filename);
  		$last = $file[count($file)-1];
    	$contentarray = explode("<>",$last);
    	$num = array_shift($contentarray);
    	$num ++;
    	fwrite($fp,$num. "<>". $_POST["name"]. "<>". $_POST["comment"]. "<>". date( "Y/m/d a h:i:s", $timestamp ). "\r\n");    
   		fclose($fp);
 	}
  }
}
if (isset($_POST["delete"])) {
  $filename = "mission_3-1.txt";
  $fileCont = file($filename);
  $deletenum = $_POST["deletenum"];
  $fp = fopen($filename,"w");
  foreach ($fileCont as $row) {
    $arr = explode("<>", $row);
        if($deletenum !== $arr[0]){
        fwrite($fp,$row);  
        }
     }
      fclose($fp);
      unset($row);
}
  echo "過去のコメント<br>";
  $filename = "mission_3-1.txt";
  $file = file($filename);
  foreach ($file as $row) {
  	    $arr = explode("<>", $row);
  		foreach ($arr as $value){
    		echo $value. " ";
  		}
    	unset($value);
    	echo "<br>";
  	}
  	unset($row);

?>
</body>
</html>

