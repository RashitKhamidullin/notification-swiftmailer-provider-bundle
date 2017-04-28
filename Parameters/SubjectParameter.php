<?php
namespace Brp\NotificationSwiftMailerProviderBundle\Parameters;

use Brp\NotificationSenderBundle\Parameter\StringProviderParameter;

class SubjectParameter extends StringProviderParameter
{
    public function getName()
    {
        return 'subject';
    }

    public function getCode()
    {
        return 'Subject';
    }

    public function getType()
    {
        return 'string';
    }
}