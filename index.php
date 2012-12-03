<?php
/*

Author Timi Wahalahti (http://wahalahti.fi)
This work is licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported License. To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/.

*/

$config_json = file_get_contents("config.json");
$config = json_decode($config_json);
$user_file = file($config->users_file);
$auth_file = file_get_contents($config->auth_file);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $config->site_name; ?></title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		
		$("#adduser").click(function() {
		
			var action = $("#form1").attr('action');
			var form_data = {
				username: $("#username").val(),
				password: $("#password").val(),
				is_ajax: 1,
				func: 1
			};
			
			$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				dataType: "json",
				success: function(response)
				{
					if(response.type == 'success') {
						$("#message").delay(2000).slideUp('slow');
						$("#message").html(response.message);
						$("#username").val("");
						$("#password").val("");
						setTimeout(function() {
							location.reload();
						}, 2500);
					}
					if(response.type == 'error') {
						$("#message").html(response.message);
					}	
				}
			});
			
			return false;
		});
		$("#deluser").click(function() {
		
			var action = $("#form2").attr('action');
			var form_data = {
				line: $("input[name='line']:checked").val(),
				is_ajax: 1,
				func: 2
			};
			
			$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				dataType: "json",
				success: function(response)
				{
					if(response.type == 'success') {
						$("#message2").delay(2000).slideUp('slow');
						$("#message2").html(response.message);
						$('#form2').get(0).reset();
						$('form[name=form2]').get(0).reset();
						setTimeout(function() {
							location.reload();
						}, 2500);
					}
					if(response.type == 'error') {
						$("#message2").html(response.message);
					}
				}
			});
			
			return false;
		});
		$("#modify").click(function() {
		
			var action = $("#form3").attr('action');
			var form_data = {
				content: $("#roles").val(),
				is_ajax: 1,
				func: 3
			};
			
			$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				dataType: "json",
				success: function(response)
				{
					if(response.type == 'success') {
						$("#message3").delay(2000).slideUp('slow');
						$("#message3").html(response.message);
						setTimeout(function() {
							location.reload();
						}, 2500);
					}
					if(response.type == 'error') {
						$("#message3").html(response.message);
					}
				}
			});
			
			return false;
		});
		
	});
	</script>


</head>
<body>
<div id="wrapper">
	<div id="header">
		<h1><?php echo $config->site_text[0]->title; ?></h1>
		<div class="expl"><p><?php echo $config->site_text[0]->expl; ?></p></div>
	</div>
	<div id="message"></div>
	<div class="form_wrapper">
		<h2><?php echo $config->site_text[1]->header; ?></h2>
		<p><?php echo $config->site_text[1]->expl; ?></p>
		<form id="form1" name="form1" action="functions.php" method="post" autocomplete="off">
		<label><?php echo $config->site_text[1]->username; ?></label>
		<input type="text" id="username" name="username" />
		<label><?php echo $config->site_text[1]->passwd; ?></label>
		<input type="password" id="password" name="password" /><br/>
		<input class="button" type="submit" id="adduser" value="<?php echo $config->site_text[1]->button; ?>" />
		</form>
	</div>

	<div id="message2"></div>
	<div class="form_wrapper">
		<?php
		$firstLine = array_shift($user_file);
		echo "<h2>" . $config->site_text[2]->header . "</h2>";
		echo "<p>" . $config->site_text[2]->expl . "</p>";
		if (empty($user_file)) {
			echo "<p class='error'>" . $config->site_text[2]->no_users . "</p>";
		} else {
		?>
		<form id="form2" name="form2" action="functions.php" method="post" autocomplete="off">
		<?php
		foreach($user_file as $key => $val) {
			$user = substr($val, 0, strpos($val, '='));
			$lineKey = $key+1;
			$line = @$line . "<input type='radio' name='line' value='$lineKey'>" . $user . "</input><br>";
		}
		echo $line;
		?>
		<input class="button" type="submit" id="deluser" value="<?php echo $config->site_text[2]->button; ?>" />
		<?php } ?>
		</form>
	</div>

	<div id="message3"></div>
	<div class="form_wrapper">
		<h2><?php echo $config->site_text[3]->header; ?></h2>
		<p><?php echo $config->site_text[3]->expl; ?></p>
		<form id="form3" name="form3" action="functions.php" method="post" autocomplete="off">
		<textarea type="textarea" name="roles" id="roles" rows="25" cols="57"><?php echo $auth_file ?></textarea>
		<input class="button" type="submit" id="modify" value="<?php echo $config->site_text[3]->button; ?>" />
		</form>
	</div>
</div>
</body>
</html>