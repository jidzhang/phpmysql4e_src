<?php

// create short variable name
$tireqty = $_POST['tireqty'];
$oilqty = $_POST['oilqty'];
$sparkqty = $_POST['sparkqty'];
$find = $_POST['find'];
$address = $_POST['address'];
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
$date = date('H:i, jS F Y');

?>

<html>
<head><title>Bob's Auto Parts - Order Results</title></head>
<body>
<h1>Bob's Auto Parts</h1>
<h2>Order Results</h2>

<?php
echo '<p>Order processed at '.date('H:i, jS F Y').'</p>';
echo '<p>Your order is as follow:</p>';
echo $tireqty.' tires<br />';
echo $oilqty.' bottles of oil<br />';
echo $sparkqty.' spark plugs<br />';

$totalqty = $tireqty + $oilqty + $sparkqty;
if ($totalqty == 0) {
    echo '<p style="color: red">';
    echo 'You did not order anything on the previous page!';
    echo '</p>';
} else {
    echo '<p style="color: red">';
    echo 'Your order is as follow: <br />';
    echo $tireqty.' tires<br />';
    echo $oilqty.' bottles of oil<br />';
    echo $sparkqty.' spark plugs<br />';
    echo '</p>';
}
//
switch($find) {
    case 'a':
        echo '<p>Regular customer.</p>';
        break;
    case 'b':
        echo '<p>Customer referred by TV advert.</p>';
        break;
    case 'c':
        echo '<p>Customer referred by phone directory.</p>';
        break;
    case 'd':
        echo '<p>Customer referred by word of mouth.</p>';
        break;
    default:
        echo '<p>We do not know how this customer found us.</p>';
        break;
}

define('TIREPRICE', 100);
define('OILPRICE', 10);
define('SPARKPRICE', 4);

$totalamount = $tireqty * TIREPRICE + $oilqty * OILPRICE + $sparkqty * SPARKPRICE;

echo 'Subtotal: $'.number_format($totalamount, 2).'<br />';

$taxrate = 0.10;
$totalamount = $totalamount * (1 + $taxrate);
echo 'Total including tax : $'.number_format($totalamount, 2).'<br />';

$out = `ls -al`;
echo '<pre>'.$out.'</pre>';

echo 'isset($tireqty):'.isset($tireqty).'<br />';
echo 'isset($nothere):'.isset($nothere).'<br />';
echo 'empty($tireqty):'.empty($tireqty).'<br />';
echo 'empty($nothere):'.empty($nothere).'<br />';

//
echo '<p>Address to ship to is '.$address.'</p>';

$outputstring = $date."\t".$tireqty." tires \t".$oilqty." oil\t"
    .$sparkqty." spark plugs\t\$".$totalamount."\t".$address."\n";

// open file for appending
@$fp = fopen("$DOCUMENT_ROOT/../orders/orders.txt", 'ab');
if (!$fp) {
    echo "<p><strong>Your order could not be processed at this time.
        Please try again later.</strong></p></body></html>";
    exit;
}
flock($fp, LOCK_EX);
fwrite($fp, $outputstring, strlen($outputstring));
flock($fp, LOCK_UN);
fclose($fp);

echo "<p>Order written.</p>";

?>
</body>
</html>