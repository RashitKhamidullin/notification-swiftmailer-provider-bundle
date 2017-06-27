<?php

/**
 * User: Rashit Khamidullin Rashit.Kamidullin@gmail.com
 * Date: 23.06.17
 * Time: 18:31
 */

namespace Brp\NotificationSwiftMailerProviderBundle\Tests\Provider;

use Brp\NotificationSenderBundle\Parameter\ProviderConnectionParameterInterface;
use Brp\NotificationSenderBundle\Parameter\ProviderTemplateParameterInterface;
use Brp\NotificationSenderBundle\Provider\ProviderInterface;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\BodyParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\EmailFromParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\EmailToParameter;
use Brp\NotificationSwiftMailerProviderBundle\Parameters\SubjectParameter;
use Brp\NotificationSwiftMailerProviderBundle\Provider\SwiftMailerProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SwiftMailerProviderTest extends WebTestCase
{
    /** @var SwiftMailerProvider|ProviderInterface $provider */
    private $provider;

    protected function setUp()
    {
        $this->provider = new SwiftMailerProvider();
        $this->fillConnectionParameters();
        $this->fillTemplateParameters();
    }

    public function testCheckAvailability()
    {
        $this->assertNotEquals(true, $this->provider->checkAvailable());
    }

    public function testConnectionParams()
    {
        $this->assertContainsOnlyInstancesOf(
            ProviderConnectionParameterInterface::class,
            $this->provider->getConnectionParams()
        );
    }

    public function testTemplateParams()
    {
        $this->assertContainsOnlyInstancesOf(
            ProviderTemplateParameterInterface::class,
            $this->provider->getTemplateParams()
        );
    }

    public function testLoader()
    {
        $loader = $this->getMockBuilder(\Twig_LoaderInterface::class)->getMock();

        $loader->expects($this->once())->method('getSource')->with('base.html');

        $this->provider->setLoader($loader);
        $this->fillTemplateParameters(['Body' => '{% extends "base.html" %}{% block content %}Hello {{ name }}{% endblock %}']);

        $this->setExpectedException(\Swift_TransportException::class);
        $this->provider->send();
    }

    public function testCreateMessage()
    {
        /** @var \Swift_Message $message */
        $message = new \ReflectionMethod(SwiftMailerProvider::class, 'createMessage');
        $message->setAccessible(true);
        $message = $message->invoke($this->provider);


        $this->assertEquals('Subject', $message->getSubject());
        $this->assertEquals('from@gmail.com', key($message->getFrom()));
        $this->assertEquals('to@gmail.com', key($message->getTo()));
        $this->assertEquals('body', $message->getBody());
        $this->assertEquals('text/html', $message->getContentType());
    }

    private function fillConnectionParameters()
    {
        $connectionParams = $this->provider->getConnectionParams();

        foreach ($connectionParams as $cp) {
            $cp->setValue('dummy');
        }
    }

    private function fillTemplateParameters($parameters = [])
    {
        $templateParams = $this->provider->getTemplateParams();

        foreach ($templateParams as $tp) {

            switch(true) {
                case $tp instanceof SubjectParameter:   $tp->setValue('Subject');        break;
                case $tp instanceof EmailFromParameter: $tp->setValue('from@gmail.com'); break;
                case $tp instanceof EmailToParameter:   $tp->setValue('to@gmail.com');   break;
                case $tp instanceof BodyParameter:      $tp->setValue('body');           break;
            }

            if (array_key_exists($tp->getCode(), $parameters)) {
                $tp->setValue($parameters[$tp->getCode()]);
            }
        }

    }
}
