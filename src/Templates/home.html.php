<?php
if(!isset($_GET['view'])){
    $_GET['view'] = "earnings";
}


$repo = $GLOBALS['dataService'];
$user = unserialize(base64_decode($_SESSION['logged_user']));

function get_earnings(): array {
    global $repo;
    global $user;
    
    $earnings = $repo->findTransactionsWithFilter(['obligee_id' => $user->id]);

    return $earnings;
};

function get_spendings(): array {
    global $repo;
    global $user;

    $spendings = $repo->findTransactionsWithFilter(['debtor_id' => $user->id]);

    return $spendings;
};
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Home</title>
	</head>
	<body>

        <!-- TODO: add function that switchs -->
        <a href="?view=earnings" onclick="">Earnings</a>
        <a href="?view=spendings" onclick="">Spendings</a>
        </br>
        History for this month

        <?php
            if($_GET['view']=="earnings") {
                $transfer_data = get_earnings();
            }elseif($_GET['view']=="spendings"){
                $transfer_data = get_spendings();
            }

            foreach($transfer_data as $data) {
                echo '<hr style="width:50%;text-align:left;margin-left:0">';
                print_r($data);
            }
        ?>


    </body>
</html>
