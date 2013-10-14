<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.hmac_otp.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 14.10.2013, 16:57:33 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Vieri Giovambattista
 * @see http://en.wikipedia.org/wiki/HMAC

http://tools.ietf.org/html/rfc6238
 * @since 2013
 * @version 0
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000866-includes begin
// section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000866-includes end

/* user defined constants */
// section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000866-constants begin
// section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000866-constants end

/**
 * Short description of class hmac_otp
 *
 * @access public
 * @author Vieri Giovambattista
 * @see http://en.wikipedia.org/wiki/HMAC

http://tools.ietf.org/html/rfc6238
 * @since 2013
 * @version 0
 */
class hmac_otp
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * this is the seed
     *
     * @access private
     * @var int
     */
    private $seed = 0;

    /**
     * time window. it is really important. one minute can be sufficient on some
     * system... But you have to tune it.
     *
     * @access private
     * @var int
     */
    private $timeWindow = 60;

    /**
     * Short description of attribute time
     *
     * @access private
     * @var int
     */
    private $time = 0;

    /**
     * Short description of attribute exactTime
     *
     * @access private
     * @var int
     */
    private $exactTime = 0;

    /**
     * the algorithms used to calculate the whole thing.
     *
     * @access private
     * @var string
     */
    private $algo = 'sha1';

    /**
     * it is the parameter used to decide if the token will be of 6 or 8 digits.
     * default value is 8.
     *
     * @access private
     * @var int
     */
    private $returnDigits = 8;

    /**
     * this is a flag. If its value is zero, the time returned by system call
     * be used. If its value is not zero, its value will be used to calculate
     * token. It is really important to debug the whole thing.
     *
     * @access private
     * @var int
     */
    private $testTime = 0;

    // --- OPERATIONS ---

    /**
     * Short description of method getTimeFromClock
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @return int
     */
    public function getTimeFromClock()
    {
        $returnValue = (int) 0;

        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000879 begin
	$returnValue=time();	
        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000879 end

        return (int) $returnValue;
    }

    /**
     * Short description of method setSeed
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  string newSeed
     */
    public function setSeed($newSeed)
    {
        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:000000000000087B begin
	$this->seed=$newSeed;

        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:000000000000087B end
    }

    /**
     * Short description of method setTimeWindow
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  int newTimeWindow
     */
    public function setTimeWindow($newTimeWindow)
    {
        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000880 begin
	$this->timeWindow=$newTimeWindow;
        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000880 end
    }

    /**
     * Short description of method calculateOtp
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @return Integer
     */
    public function calculateOtp()
    {
        $returnValue = null;

        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000882 begin
	if($this->testTime==0) {
		$this->time= $this->getTimeFromClock();
	} else {
		$this->time=$this->testTime;
	}

	$roundedTime=floor($this->time/$this->timeWindow);
	$packedTime =pack("N",$roundedTime); 		//"N" unsigned long (always 32 bit, big endian byte order)
//	$this->paddedPacketTime= str_pad($packedTime,8, chr(0),STR_PAD_LEFT); // 8 is the exponent so we are generating an otp with 8 digit
	$paddedPackedTime= str_pad($packedTime,$this->returnDigits, chr(0),STR_PAD_LEFT); // 8 is the exponent so we are generating an otp with 8 digit
	$packedSecretSeed= pack ("H*", $this->seed);	//Hex string, high nibble first 
	$hash = hash_hmac ($this->algo, $paddedPackedTime, $packedSecretSeed, true);
// Extract the 8 digit number fromt the hash as per RFC 6238
// this must be parametrized.

	$offset = ord($hash[strlen($hash)-1]) & 0xf;
	$otp = (
	    ((ord($hash[$offset+0]) & 0x7f) << 24 ) |
	    ((ord($hash[$offset+1]) & 0xff) << 16 ) |
	    ((ord($hash[$offset+2]) & 0xff) << 8 ) |
	    (ord($hash[$offset+3]) & 0xff)
	) % pow(10, $this->returnDigits); // 8 must be parametrized too...
	$otp = str_pad($otp, $this->returnDigits, "0", STR_PAD_LEFT); // zero padding to the left

	$returnValue=$otp;

        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000882 end

        return $returnValue;
    }

    /**
     * Short description of method verifyOtp
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  Integer otpToBeVerified
     * @return mixed
     */
    public function verifyOtp( Integer $otpToBeVerified)
    {
        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000884 begin
	$otp=$this->calculateOtp();
	
        // section -64--88-2-49-40c8ddb2:141659673a6:-8000:0000000000000884 end
    }

    /**
     * Short description of method setAlgo
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  string algo
     */
    public function setAlgo($algo)
    {
        // section 127-0-1-1-76ed6357:141ad9dc388:-8000:0000000000000A96 begin
	$arrayOfAlgo=hash_algos();
	if (in_array($algo,$arrayOfAlgo))  {
		$this->algo=$algo;
	} else {
		throw new Exception('not (yet) supported algo');
	
	}
        // section 127-0-1-1-76ed6357:141ad9dc388:-8000:0000000000000A96 end
    }

    /**
     * Short description of method setReturnDigits
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  int newReturnDigits
     */
    public function setReturnDigits($newReturnDigits)
    {
        // section 127-0-1-1-76ed6357:141ad9dc388:-8000:0000000000000A9D begin
	if ($newReturnDigits<1 || $newReturnDigits>8) {
		throw new Exception('returnDigits out of range');
	}
	$this->returnDigits=$newReturnDigits;
        // section 127-0-1-1-76ed6357:141ad9dc388:-8000:0000000000000A9D end
    }

    /**
     * Short description of method setTestTime
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  int newTestTime
     */
    public function setTestTime($newTestTime)
    {
        // section 127-0-1-1-20256da1:141adc9dc6a:-8000:0000000000000AA3 begin
	if ($newTestTime<0) {
		throw new Exception('testTime negative');
	}
	
	$this->testTime=$newTestTime;
        // section 127-0-1-1-20256da1:141adc9dc6a:-8000:0000000000000AA3 end
    }

} /* end of class hmac_otp */

?>
