<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; UTF-8">
<title>Payment Process</title>
<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>

<?php

require_once 'Payments.php';
$payments = new Payments();
$result = $payments->process();
echo $result;
?>

</body>
</html>
