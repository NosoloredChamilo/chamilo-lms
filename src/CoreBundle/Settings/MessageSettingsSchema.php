<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Settings;

use Chamilo\CoreBundle\Form\Type\YesNoType;
use Sylius\Bundle\SettingsBundle\Schema\AbstractSettingsBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class MessageSettingsSchema extends AbstractSettingsSchema
{
    public function buildSettings(AbstractSettingsBuilder $builder): void
    {
        $builder
            ->setDefaults(
                [
                    'allow_message_tool' => 'true',
                    'allow_send_message_to_all_platform_users' => 'false',
                    'message_max_upload_filesize' => '20971520',
                    'private_messages_about_user' => 'false',
                    'private_messages_about_user_visible_to_user' => 'false',
                ]
            )
        ;
        $allowedTypes = [
            'allow_message_tool' => ['string'],
            'message_max_upload_filesize' => ['string'],
        ];
        $this->setMultipleAllowedTypes($allowedTypes, $builder);
    }

    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder
            ->add('allow_message_tool', YesNoType::class)
            ->add('allow_send_message_to_all_platform_users', YesNoType::class)
            ->add('message_max_upload_filesize')
            ->add('private_messages_about_user', YesNoType::class)
            ->add('private_messages_about_user_visible_to_user', YesNoType::class)
        ;
    }
}
