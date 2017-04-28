<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\ArrayProviderParameter;

class EmailToParameter extends ArrayProviderParameter
{
    public function getName()
    {
        return 'email_to';
    }

    public function getCode()
    {
        return 'EmailTo';
    }

    public function getType()
    {
        return 'string';
    }
}