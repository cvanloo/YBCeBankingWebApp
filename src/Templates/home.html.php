<?php
if(!isset($_GET['home_mode'])){
    $_GET['home_mode'] = "earnings";
}


$repo = $GLOBALS['dataService'];

function get_earnings($user): array{
    $filter = array('obligee_id=='+$user);
    #$earnings = $repo->findTransactionsWithFilter($filter);

    $earnings = [
        "key1" => "earning1",
        "key2" => "earning2",
        "key3" => "earning3",
    ];
    return $earnings;
};

function get_spendings($user): array{
    $filter = array('debtor_id=='+$user);
    #$spendings = $repo->findTransactionsWithFilter($filter);

    $spendings = [
        "key1" => "spending1",
        "key2" => "spending2",
        "key3" => "spending3",
    ];

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
        <a href="" onclick="">Earnings</a>
        <a href="" onclick="">Spendings</a>
        </br>
        History for this month

        <?php
            if($_GET['home_mode']=="earnings"){
                $transfer_data = get_earnings($_SESSION['user']);
            }elseif($_GET['home_mode']=="spendings"){
                $transfer_data = get_spendings($_SESSION['user']);
            }

            foreach($transfer_data as $data){
                echo '<hr style="width:50%;text-align:left;margin-left:0">';
                echo $data;
            }
        ?>


    </body>
</html>
