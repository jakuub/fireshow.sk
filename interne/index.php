<?php
session_start();

function format_bytes($bytes) {
   if ($bytes < 1024) return $bytes.' B';
   elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
   elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
   elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
   else return round($bytes / 1099511627776, 2).' TB';
}

if(isset($_POST['login'])){					//login
  if(isset($_POST['nick'])&&
     $_POST['nick']=='flagrans'&&
     isset($_POST['password'])&&
     $_POST['password'] == 'plamen'){
		$_SESSION['ok']=1;
  }

}
if (isset($_POST['logout'])){
	session_unset();
}			//odhlasenie



if(!isset($_SESSION['ok']) || ! $_SESSION['ok']){
?>
<div id="login_div">
  <form action="" method="post" id="log">
  <fieldset id="login">  
    <label for="nick">Nick: </label><input type="text" name="nick" id="nick" size="10" maxlength="10" value=""/><br /> 
    <label for="password">Password: </label><input type="password" name="password" id="password" size="10" maxlength="10" value=""/><br /> 
    <button type="submit" name="login">Log In</button> 
  </fieldset>
  </form>
</div>
<?php	
}elseif($_SESSION['ok']){
	
?>	
      <form action="" method="post" id="reg" enctype="multipart/form-data" style="position: relative; float: left; heigth: 2em;">
      <fieldset id="zmena">  
      <!--<input type="hidden" name="MAX_FILE_SIZE" value="100000" />-->
      subor: <input name="uploadedfile" type="file" />  <br />
      <button type="submit" name="upravprofil">uploaduj</button> 
      </fieldset>
      </form>
      <form action="" method="post" id="reg" enctype="multipart/form-data" style="position: relative; float: left; heigth: 2em;">
      <fieldset id="zmena">  
        <button type="submit" name="logout">Logout</button> <br />&nbsp; 
      </fieldset>
      </form> <br />

	
<?php	
	

	if (isset($_FILES['uploadedfile'])){
		//echo 'isset';
		$target_path = "";
		$target_path = $target_path .basename( $_FILES['uploadedfile']['name']); 
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
				echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded";
			
			//echo $sql  ;
		} else{
				echo "There was an error uploading the file, please try again!";
		}
	}

?>
      <div style="position: relative; clear: both;">
				<table>
					<tr><th>Subor</th><th>&nbsp &nbsp velkost &nbsp &nbsp </th><th> datum poslednej upravy/uploadu </th></tr>
<?

if ($handle = opendir(".")) {
			while ($file = readdir($handle))
      {
				if($file != ".." && $file != "." && $file != "index.php")
					echo "<tr><td><a href=\"$file\">$file</a></td><td> &nbsp &nbsp ".format_bytes(filesize($file))." &nbsp &nbsp </td><td> ".date("d.m.Y ..... H:i", filemtime($file))." </td></tr>
";
       }
			 closedir($handle);
}


?>
				</table>
			</div>
<?

}





?>
