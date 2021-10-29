<?php
    use Modules\Entities\User;

    $message = "";
    if(isset($_POST["register"])){
        $result = checkRegister();
        $user = $result['user'];
        $message = $result['message'];

        if(null !== $user){
            // Save user to session.
            $_SESSION['user'] = $user;
        }
    }
    function  checkRegister() : array {
        // Validate user input.
        $username = htmlspecialchars($_POST["username"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);
        $passwordR = htmlspecialchars($_POST["passwordR"]);
        if(empty($_POST["username"])){
            return array('user' => null, 'message' => "Please enter username!");
        }
        if(empty($_POST["email"])){
            return array('user' => null, 'message' => "Please enter email!");
        }
        if(empty($_POST["password"])){
            return array('user' => null, 'message' => "Please enter password!");
        }
        if(empty($_POST["passwordR"])){
            return array('user' => null, 'message' => "Please repeat Password!");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array('user' => null, 'message' => "Email isn't valid!");
        }
        if($password !== $passwordR){
            return array('user' => null, 'message' => "Passwords aren't identical!");
        }

        // Create user.
        $password = password_hash($password, PASSWORD_DEFAULT);

        $repo = $GLOBALS['dataService'];
		$user = User::create()->setEmail($email)->setUsername($username)->setPasswdhash($password)->setAccountbalance(0);
		$created_user = $repo->createUser($user);

        if (null === $created_user) {
            return array('user' => null, 'message' => "Email already exists!");
        } 

        return array('user' => $user, 'message' => "Account successfully created.");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Register</h1>
    <form method="post" action="#">
    <input type="text" placeholder="Username" name="username" value="<?php if(isset($_POST["username"])){echo htmlspecialchars($_POST["username"]);} ?>">
    <input type="email" placeholder="Email" name="email" value="<?php if(isset($_POST["email"])){echo htmlspecialchars($_POST["email"]);} ?>">
    <input type="password" placeholder="Password" name="password" value="<?php if(isset($_POST["password"])){echo htmlspecialchars($_POST["password"]);} ?>">
    <input type="password" placeholder="Repeat Password" name="passwordR" value="<?php if(isset($_POST["passwordR"])){echo htmlspecialchars($_POST["passwordR"]);} ?>">
    <div id="buttons">
        <button type="button" onclick="window.location = '/Auth/Login';" style="cursor:pointer; float:left; background-color:lightgrey; border:none; width:14vw; font-size:3vw; padding: 0.5vh;">Log In</button>
        <button type="submit" name="register" style="float:right; background-color:black; color:white; border:none; width:14vw; font-size:3vw; padding: 0.5vh;">Register</button>
    </div>
    <form>
    <div id="errorDisplay">
    <?php echo $message;?>
    </div>
</body>
</html>