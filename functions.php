<?php
$config_json = file_get_contents("config.json");
$config = json_decode($config_json);
$is_ajax = $_POST['is_ajax'];

$func = $_POST['func'];
if (isset($func)) {
	if ($func == 1) {
		call_user_func('add');
	}
	if ($func == 2) {
		call_user_func('delete');
	}
	if ($func == 3) {
		call_user_func('modify');
	}
} else {
	echo "Do not load page directly!";
}


function add() {
	global $config;
	global $is_ajax;

	if (isset($is_ajax) && $is_ajax) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		if ($username != "" && $password != "") {
			$content = "$username = $password\n";
			$put = file_put_contents($config->users_file, $content, FILE_APPEND);

			if($put === 'FALSE') {
				$response['type'] = 'error';
				$response['message'] = '<p class="error">'. $config->erros[0]->add_general . '</p>';
			} else {
				$response['type'] = 'success';
				$response['message'] = '<p>' . $config->succes[0]->add . ': ' . $username . '</p>';
			}
		} elseif ($username == "") {
			$response['type'] = 'error';
			$response['message'] = '<p class="error">' . $config->errors[0]->add_username . '</p>';
		} elseif ($password == "") {
			$response['type'] = 'error';
			$response['message'] = '<p class="error">' . $config->errors[0]->add_passwd . '</p>';
		}
		print json_encode($response);
	}
}
// end of function add

function delete() {
	global $config;
	global $is_ajax;

	if (isset($is_ajax) && $is_ajax) {
		$line = $_POST['line'];
		$lines = file( $config->users_file );
		unset( $lines[$line] );

		if ( file_put_contents( $config->users_file, implode( '', $lines ), LOCK_EX ) )
		{
			$response['type'] = 'success';
			$response['message'] = '<p>' . $config->succes[0]->delete . '</p>';
		} else {
			$response['type'] = 'error';
			$response['message'] = '<p class="error">' . $config->errors[0]->delete . '</p>';
		}
		print json_encode($response);
	}

}
// end of function delete

function modify() {
	global $config;
	global $is_ajax;
	$file = fopen($config->auth_file, "w");

	if (isset($is_ajax) && $is_ajax) {
		$content = $_POST['content'];
		$content = stripslashes($content);
		$write = fwrite($file, $content);
		fclose($file);
		if ($write === 'FALSE') {
			$response['type'] = 'error';
			$response['message'] = '<p class="error">' . $config->errors[0]->modify . '</p>';
		} else {
			$response['type'] = 'success';
			$response['message'] = '<p>' . $config->succes[0]->modify . '</p>';
		}
		print json_encode($response);
	}
}
// end of function modify

?>