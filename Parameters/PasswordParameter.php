<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\ProviderConnectionParameterInterface;

class PasswordParameter implements ProviderConnectionParameterInterface
{
    private $value;

    public function getName()
    {
        return 'password';
    }

    public function getCode()
    {
        return 'Password';
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