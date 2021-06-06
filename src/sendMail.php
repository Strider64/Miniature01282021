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

    public function validationFCN($length = 15, $characters = true, $numbers = true, $case_sensitive = true, $hash = false ): string
    {

        $password = '';

        if($characters)
        {
            $charLength = $length;
            if($numbers) {
                $charLength -= 2;
            }
            if($case_sensitive) {
                $charLength -= 2;
            }
            if($hash) {
                $charLength -= 2;
            }
            $chars = "abcdefghijklmnopqrstuvwxyz";
            $password.= substr( str_shuffle( $chars ), 0, $charLength );
        }

        if($numbers)
        {
            $numbersLength = $length;
            if($characters) {
                $numbersLength -= 2;
            }
            if($case_sensitive) {
                $numbersLength -= 2;
            }
            if($hash) {
                $numbersLength -= 2;
            }
            $chars = "0123456789";
            $password.= substr( str_shuffle( $chars ), 0, $numbersLength );
        }

        if($case_sensitive)
        {
            $UpperCaseLength = $length;
            if($characters) {
                $UpperCaseLength -= 2;
            }
            if($numbers) {
                $UpperCaseLength -= 2;
            }
            if($hash) {
                $UpperCaseLength -= 2;
            }
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $password.= substr( str_shuffle( $chars ), 0, $UpperCaseLength );
        }

        if($hash)
        {
            $hashLength = $length;
            if($characters) {
                $hashLength -= 2;
            }
            if($numbers) {
                $hashLength -= 2;
            }
            if($case_sensitive) {
                $hashLength -= 2;
            }
            $chars = "!@#$%^&*()_-=+;:,.?";
            $password.= substr( str_shuffle( $chars ), 0, $hashLength );
        }

        return str_shuffle( $password );
    }

    public function verificationEmail($data) {
        /* Setup swiftmailer using your email server information */
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername("chalkboardquiz@gmail.com")
            ->setPassword(G_PASSWORD);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        /* create message */
        $message = (new Swift_Message('Verification of Account'))
            ->setFrom(['john.pepp@miniaturephotographer.com' => 'John Pepp'])
            ->setTo([$data['email'] => $data['name']])
            ->setBody($data['message'], 'text/html')
            ->attach(entity: Swift_Attachment::fromPath('https://www.miniaturephotographer.com/assets/images/img-logo-003.jpg'));

        /* Send the message */
        return $mailer->send($message);
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
