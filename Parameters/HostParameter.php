<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\ProviderConnectionParameterInterface;

class HostParameter implements ProviderConnectionParameterInterface
{
    private $value;

    public function getName()
    {
        return 'host';
    }

    public function getCode()
    {
        return 'Host';
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