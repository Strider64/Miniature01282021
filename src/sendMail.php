<?php

namespace Miniature;

/*
 * In order to use swiftmailer the below is needed....
 */

use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;

class sendMail {

    public $result = \NULL;
    public $subject = \NULL;
    public $sendTo = [];
    public $sendFrom = [];
    public $content = \NULL;

    public function __construct() {
        
    }

    public function sendTo(array $sendTo) {
        $this->sendTo = $sendTo;
    }

    public function sendFrom(array $sendFrom = ['jrpepp@pepster' => 'John Pepp']) {
        $this->sendFrom = $sendFrom;
    }

    public function subject($subject) {
        $this->subject = $subject;
    }

    public function content($content) {
        $this->content = $content;
    }

    public function sendEmail() {
        /* Setup swiftmailer using your email server information */
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', EMAIL_PORT, 'tls'))
                ->setUsername(G_USERNAME)
                ->setPassword(G_PASSWORD);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        /* create message */
        $message = (new Swift_Message($this->subject))
                ->setFrom($this->sendFrom)
                ->setTo($this->sendTo)
                ->setBody($this->content);

        /* Send the message */
        return $mailer->send($message);
    }

}
