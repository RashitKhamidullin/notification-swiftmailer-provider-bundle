<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Provider;

use Brp\NotificationSenderBundle\Provider\ProviderInterface;

use Brp\NotificationSwiftMailerProviderBundle\Parameters\BodyParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\CarbonCopyParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\EmailFromParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\EmailToParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\SslParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\SubjectParameter;

use Brp\NotificationSwiftMailerProviderBundle\Parameters\HostParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\PasswordParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\PortParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\UserNameParameter;


class SwiftMailerProvider implements ProviderInterface
{
    private $mailer;

    private $host;
    private $port;
    private $userName;
    private $password;
    private $ssl;

    private $subject;
    private $emailFrom;
    private $emailTo;
    private $body;
    private $cc;

    private $templateParams = array();
    private $connectionParams = array();

    public function __construct(\Twig_Environment $tw)
    {
        $this->host     = new HostParameter();
        $this->port     = new PortParameter();
        $this->userName = new UserNameParameter();
        $this->password = new PasswordParameter();
        $this->ssl      = new SslParameter();

        $this->connectionParams[]     = $this->host;
        $this->connectionParams[]     = $this->port;
        $this->connectionParams[] = $this->userName;
        $this->connectionParams[] = $this->password;
        $this->connectionParams[]      = $this->ssl;

        $this->subject   = new SubjectParameter($tw);
        $this->emailFrom = new EmailFromParameter($tw);
        $this->emailTo   = new EmailToParameter();
        $this->cc        = new CarbonCopyParameter();
        $this->body      = new BodyParameter($tw);

        $this->templateParams[]   = $this->subject;
        $this->templateParams[] = $this->emailFrom;
        $this->templateParams[]   = $this->emailTo;
        $this->templateParams[]        = $this->cc;
        $this->templateParams[]      = $this->body;
    }

    public function send()
    {
        $transport = \Swift_SmtpTransport::newInstance(
            $this->host->getValue(),
            $this->port->getValue(),
            'SSL'
        )
            ->setUsername($this->userName->getValue())
            ->setPassword($this->password->getValue())
        ;

        $this->mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($this->subject->getConvertedValue())
            ->setFrom($this->emailFrom->getConvertedValue())
            ->setTo($this->emailTo->getConvertedValue())
            ->setCc($this->cc->getConvertedValue())
            ->setBody($this->body->getConvertedValue())
        ;

        $this->mailer->send($message);
    }

    public function getConnectionParams()
    {
        return $this->connectionParams;
    }

    public function getTemplateParams()
    {
        return $this->templateParams;
    }

    public function checkAvailable()
    {
        try{
            $this->mailer->getTransport()->start();
            return true;
        } catch (\Swift_TransportException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCode()
    {
        return 'brp.swift.mailer';
    }

    public function getDescription()
    {
        return 'Simple swiftmailer provider';
    }
}