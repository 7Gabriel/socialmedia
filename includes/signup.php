<?php

if (isset($_POST['signup'])) {
	$screenName = $_POST['screenName'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$error = '';
	if (empty($screenName) or empty($password) or empty($email)) {
		$error = 'All fields are required';
	}else {
		$email = $getFromU->checkInput($email);
		$password = $getFromU->checkInput($password);
		$screenName = $getFromU->checkInput($screenName);
		if (!filter_var($email)) {
			$error = 'Invalid email';
		}else if (strlen($screenName) > 20) {
			$error = 'Name must be between 6-20 caracters long';
		}else if (strlen($password) < 5) {
			$error = 'Password is invalid';
		}else {
			if ($getFromU->checkEmail($email) === true) {
				$error = 'Email is already in use';
			}else {
				$getFromU->register($email, $screenName, $password);
				header('Location: home.php');
			}
		}
	}
}
?>
<form method="post">
<div class="signup-div"> 
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" placeholder="Full Name"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup">
		</li>
	</ul>
	
		<?php 
			if(isset($error)){
				echo '<li class="error-li">
				<div class="span-fp-error">'.$error.'</div>
				</li>';
			}
		?>

</div>
</form>