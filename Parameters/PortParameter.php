<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\ProviderConnectionParameterInterface;

class PortParameter implements ProviderConnectionParameterInterface
{
    private $value;

    public function getName()
    {
        return 'port';
    }

    public function getCode()
    {
        return 'Port';
    }

    public function getType()
    {
        return 'string';
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
}