<?php

namespace Miniature;

/*
 * In order to use swiftmailer the below is needed....
 */

use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;

class Email {

    public $result = \NULL;

    public function __construct(array $data) {
        $this->result = $this->email($data);
    }

    private function email(array $data) {

        /* Setup swiftmailer using your email server information */
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', EMAIL_PORT, 'tls'))
                ->setUsername(G_USERNAME)
                ->setPassword(G_PASSWORD);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($data['reason'] . ' email address ' . $data['email']))
                ->setFrom([$data['email'] => $data['name']])
                ->setTo(['jrpepp@pepster.com', 'pepster@pepster.com' => 'John Pepp'])
                ->setBody($data['phone'] . ' ' . $data['website'] . ' ' . $data['comments'])
        ;

        // Send the message
        $result = $mailer->send($message);
        return $result;
    }

}
