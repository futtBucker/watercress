<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/phpmailer/class.phpmailer.php';
require_once dirname(__FILE__) . '/phpmailer/class.smtp.php';

class Mailer extends PHPMailer
{
    function __construct()
    {
        parent::__construct(true);
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */