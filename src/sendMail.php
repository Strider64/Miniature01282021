<?php

namespace Miniature;

/*
 * In order to use swiftmailer the below is needed....
 */

use Swift_Attachment;
use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;

class sendMail {

    public $result;
    public $subject;
    public $sendTo = [];
    public $sendFrom = [];
    public $content;

    public function __construct() {
        
    }

    public function sendTo(array $sendTo): void
    {
        $this->sendTo = $sendTo;
    }

    public function sendFrom(array $sendFrom = ['jrpepp@pepster' => 'John Pepp']): void
    {
        $this->sendFrom = $sendFrom;
    }

    public function subject($subject): void
    {
        $this->subject = $subject;
    }

    public function content($content): void
    {
        $this->content = $content;
    }

    public function sendEmail($data) {
        /* Setup swiftmailer using your email server information */
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername("chalkboardquiz@gmail.com")
                ->setPassword(G_PASSWORD);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        /* create message */
        $message = (new Swift_Message('A email from ' . $data['name']))
                ->setFrom([$data['email'] => $data['name']])
                ->setTo(['john.pepp@miniaturephotographer.com'])
                ->setCc([$data['email'] => $data['name']])
                ->setBody($data['message'], 'text/html')
                ->attach(entity: Swift_Attachment::fromPath('https://www.miniaturephotographer.com/assets/images/img-logo-003.jpg'));

        /* Send the message */
        return $mailer->send($message);
    }

}
