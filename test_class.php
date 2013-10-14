<?PHP


require_once('class.hmac_otp.php');

$prova= new hmac_otp(); 

$seed="3132333435363738393031323334353637383930";
$seed32="3132333435363738393031323334353637383930".
"313233343536373839303132";




$seed64="3132333435363738393031323334353637383930".
"3132333435363738393031323334353637383930".
"3132333435363738393031323334353637383930".
"31323334";

print_r($prova);
$prova->setTimeWindow(30);
$prova->setReturnDigits(6);
print "=============================\n";
$prova->setTestTime(59);
$prova->setSeed($seed);
$prova->setAlgo('sha1');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed32);
$prova->setAlgo('sha256');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed64);
$prova->setAlgo('sha512');
print $prova->calculateOtp();
print "\n=============================\n";

print "=============================\n";
$prova->setTestTime(1111111109);
$prova->setSeed($seed);
$prova->setAlgo('sha1');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed32);
$prova->setAlgo('sha256');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed64);
$prova->setAlgo('sha512');
print $prova->calculateOtp();
print "\n=============================\n";


print "=============================\n";
$prova->setTestTime(1111111111);

$prova->setSeed($seed);
$prova->setAlgo('sha1');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed32);
$prova->setAlgo('sha256');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed64);
$prova->setAlgo('sha512');
print $prova->calculateOtp();
print "\n=============================\n";

print "=============================\n";
$prova->setTestTime(1234567890);

$prova->setSeed($seed);
$prova->setAlgo('sha1');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed32);
$prova->setAlgo('sha256');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed64);
$prova->setAlgo('sha512');
print $prova->calculateOtp();
print "\n=============================\n";

print "=============================\n";
$prova->setTestTime(2000000000);

$prova->setSeed($seed);
$prova->setAlgo('sha1');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed32);
$prova->setAlgo('sha256');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed64);
$prova->setAlgo('sha512');
print $prova->calculateOtp();
print "\n=============================\n";

print "=============================\n";
$prova->setTestTime(20000000000);

$prova->setSeed($seed);
$prova->setAlgo('sha1');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed32);
$prova->setAlgo('sha256');
print $prova->calculateOtp();
print "\n";
$prova->setSeed($seed64);
$prova->setAlgo('sha512');
print $prova->calculateOtp();
print "\n=============================\n";


?>
