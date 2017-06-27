<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\StringProviderParameter;

class EmailFromParameter extends StringProviderParameter
{
    public function getName()
    {
        return 'email_from';
    }

    public function getCode()
    {
        return 'EmailFrom';
    }

    public function getType()
    {
        return 'string';
    }

}