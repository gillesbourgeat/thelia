<?php

/*
 * This file is part of the Thelia package.
 * http://www.thelia.net
 *
 * (c) OpenStudio <info@thelia.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Thelia\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;

/**
 * Class MailingSystemModificationForm
 * @package Thelia\Form
 * @author Etienne Roudeix <eroudeix@openstudio.fr>
 */
class MailingSystemModificationForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add("enabled", CheckboxType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Enable remote SMTP use"),
                "label_attr" => ["for" => "enabled_field"],
            ])
            ->add("host", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Host"),
                "label_attr" => ["for" => "host_field"],
            ])
            ->add("port", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Port"),
                "label_attr" => ["for" => "port_field"],
            ])
            ->add("encryption", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Encryption"),
                "label_attr" => [
                    "for" => "encryption_field",
                    "help" => Translator::getInstance()->trans("ssl, tls or empty"),
                ],
            ])
            ->add("username", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Username"),
                "label_attr" => ["for" => "username_field"],
            ])
            ->add("password", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Password"),
                "label_attr" => ["for" => "password_field"],
            ])
            ->add("authmode", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Auth mode"),
                "label_attr" => [
                    "for" => "authmode_field",
                    "help" => Translator::getInstance()->trans("plain, login, cram-md5 or empty"),
                ],
            ])
            ->add("timeout", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Timeout"),
                "label_attr" => ["for" => "timeout_field"],
            ])
            ->add("sourceip", TextType::class, [
                "required" => false,
                "label" => Translator::getInstance()->trans("Source IP"),
                "label_attr" => ["for" => "sourceip_field"],
            ])
        ;
    }

    public function getName()
    {
        return "thelia_mailing_system_modification";
    }

    /*public function verifyCode($value, ExecutionContextInterface $context)
    {
        $profile = ProfileQuery::create()
            ->findOneByCode($value);

        if (null !== $profile) {
            $context->addViolation("Profile `code` already exists");
        }
    }*/
}
