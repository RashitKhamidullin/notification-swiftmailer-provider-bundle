<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\ProviderConnectionParameterInterface;

class UserNameParameter implements ProviderConnectionParameterInterface
{
    private $value;

    public function getName()
    {
        return 'name';
    }

    public function getCode()
    {
        return 'UserName';
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