<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Provider;

use Brp\NotificationSenderBundle\Provider\ProviderInterface;

use Brp\NotificationSwiftMailerProviderBundle\Parameters\BodyParameter;
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
    /** @var EmailFromParameter $emailFrom */
    private $emailFrom;
    private $emailTo;
    private $body;

    private $templateParams = array();
    private $connectionParams = array();

    private $tw;

    public function __construct()
    {
        $this->configureTwig();
        $this->configureConnectionParams();
        $this->configureTemplateParams();
    }

    public function send()
    {
        $this->configureMailer();

        $message = $this->createMessage();

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
        $this->configureMailer();

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

    public function setLoader(\Twig_LoaderInterface $loader)
    {
        $this->tw->setLoader($loader);
    }

    protected function configureTwig()
    {
        $this->tw = new \Twig_Environment();
        $this->tw->setCache(false);
        $this->tw->setLoader(new \Twig_Loader_Array([]));
    }

    protected function configureConnectionParams()
    {
        $this->host     = new HostParameter();
        $this->port     = new PortParameter();
        $this->userName = new UserNameParameter();
        $this->password = new PasswordParameter();
        $this->ssl      = new SslParameter();

        $this->connectionParams[] = $this->host;
        $this->connectionParams[] = $this->port;
        $this->connectionParams[] = $this->userName;
        $this->connectionParams[] = $this->password;
        $this->connectionParams[] = $this->ssl;
    }

    protected function configureTemplateParams()
    {
        $this->subject   = new SubjectParameter($this->tw);
        $this->emailFrom = new EmailFromParameter($this->tw);
        $this->emailTo   = new EmailToParameter();
        $this->body      = new BodyParameter($this->tw);

        $this->templateParams[] = $this->subject;
        $this->templateParams[] = $this->emailFrom;
        $this->templateParams[] = $this->emailTo;
        $this->templateParams[] = $this->body;
    }

    protected function configureMailer()
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
    }

    /**
     * @return \Swift_Message
     */
    protected function createMessage()
    {
        return \Swift_Message::newInstance($this->subject->getConvertedValue())
            ->setFrom($this->emailFrom->getConvertedValue())
            ->setTo($this->emailTo->getConvertedValue())
            ->setBody($this->body->getConvertedValue(), 'text/html')
        ;
    }
}