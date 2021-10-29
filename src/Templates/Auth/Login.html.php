<?php
$message = "";
if(isset($_POST["signInButton"])){
    $result = checkLogin();
    $user = $result['user'];
    $message = $result['message'];

    if (null !== $user) {
       $_SESSION['user'] = $user;
    }
}

function checkLogin() : array {
    // Validate user input.
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    if(empty($_POST["email"])){
        return array('user' => null, 'message' => "Please enter email!");
    }
    if(empty($_POST["password"])){
        return array('user' => null, 'message' => "Please enter password!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return array('user' => null, 'message' => "Email isn't valid!");
    }

    // Get user and check password.
    $repo = $GLOBALS['dataService'];
    $users = $repo->findUsersWithFilter(['email' => $email]);
    $user = $users[0];

    if (null != $user) {
        if (password_verify($password, $user->passwdhash)) {
            return array('user' => $user, 'message' => "Login successful");
        } else {
            return array('user' => null, 'message' => "Wrong Password");
        }
    } else {
        return array('user' => null, 'message' => "Email doesn't exist!");
    }
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
<h1>Sign In</h1>
<form method="post" action="#">
<input type="email" name="email" placeholder="Email" value="<?php if(isset($_POST["email"])){echo htmlspecialchars($_POST["email"]);} ?>">
<input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST["password"])){echo htmlspecialchars($_POST["password"]);} ?>">
<div id="buttons">
    <button type="button" onclick="window.location = '/Auth/Register';" style="float:left; background-color:lightgrey; border:none; width:14vw; font-size:3vw; padding: 0.5vh;">Register</button>
    <button type="submit" name="signInButton" style="float:right; background-color:black; color:white; border:none; width:14vw; font-size:3vw; padding: 0.5vh;">Sign In</button>
</div>
<div id="errorDisplay">
<?php echo $message;?>
</div>

</form>
</body>
</html>