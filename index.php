<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>InWords v1.0 (PHP)</title>
<script type="text/javascript">
	function display()
	{
		try
		{
			var val = parseInt(document.getElementById("txt_number").value, 10);
			document.getElementById("inwords").submit();
		}
		catch(err)
		{
			alert("Invalid Numbers!!!");	
		}
	}
</script>
</head>
<body>
<?php
	require("./InWords.php");
	$InWords = new InWords();
		
	$is_submitted = "";
	$txt_number = "";
	$lan = "bn";
	
	if(!empty($_POST["txt_number"]))
	{
		$txt_number = trim($_POST["txt_number"]) + 0;
	}
	if(!empty($_POST["is_submitted"]))
	{
		$is_submitted = "Yes";
		
		if(isset($_POST['radio']))
		{
			$lan = trim($_POST['radio']);
		}
	}
	
?>
<form id="inwords" name="inwords" method="post" action="index.php">
	<input type="text" id="txt_number" name="txt_number" value="<?=$txt_number?>" />&nbsp;
	<input type="radio" name="radio" id="en" value="en" <?=$lan=="en"?'checked="checked"':""?> />&nbsp;<label for="en">English</label>
    <input type="radio" name="radio" id="bn" value="bn" <?=$lan=="bn"?'checked="checked"':""?> />&nbsp;<label for="en">Bangla</label>
	 <br /><br /><input type="button" id="show" name="show" value="Display" onclick="display()" />
    <input type="hidden" id="is_submitted" name="is_submitted" value="Yes" />
</form>
<?php
echo "<br />";
if($is_submitted=="Yes")
{	
	echo "In Words: ".$InWords->InWord($txt_number, strlen($txt_number) - 1, 1, "", false, false, $lan=="en"?true:false);	
}
?>
</body>
</html>
