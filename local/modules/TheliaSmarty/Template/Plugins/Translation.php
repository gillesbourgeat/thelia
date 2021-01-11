<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TheliaSmarty\Template\Plugins;

use Symfony\Contracts\Translation\TranslatorInterface;
use Thelia\Core\Translation\Translator;
use TheliaSmarty\Template\SmartyPluginDescriptor;
use TheliaSmarty\Template\AbstractSmartyPlugin;

class Translation extends AbstractSmartyPlugin
{
    /** @var Translator */
    protected $translator;

    protected $defaultTranslationDomain = '';
    protected $defaultLocale = null;


    protected $protectedParams = [
        'l',
        'd',
        'js',
        'locale',
        'default',
        'fallback'
    ];

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Set the default translation domain
     *
     * @param array $params
     */
    public function setDefaultTranslationDomain(array $params)
    {
        $this->defaultTranslationDomain = $this->getParam($params, 'domain');
    }

    /**
     * Set the default locale
     *
     * @param array $params
     */
    public function setDefaultLocale(array $params)
    {
        $this->defaultLocale = $this->getParam($params, 'locale');
    }

    /**
     * Process translate function
     *
     * @param array $params
     * @return string
     */
    public function translate(array $params): string
    {
        // All parameters other than 'l' and 'd' and 'js' are supposed to be variables. Build an array of var => value pairs
        // and pass it to the translator
        $variables = [];

        foreach ($params as $name => $value) {
            if (!in_array($name, $this->protectedParams)) {
                $variables["%$name"] = $value;
            }
        }

        $string = $this->translator->translate(
            $this->getParam($params, 'l'),
            $variables,
            $this->getParam($params, 'd', $this->defaultTranslationDomain),
            $this->getParam($params, 'locale', $this->defaultLocale),
            $this->getBoolean($this->getParam($params, 'default', true), true),
            $this->getBoolean($this->getParam($params, 'fallback', true), true)
        );

        if ($this->getParam($params, 'js', 0)) {
            $string = preg_replace("/(['\"])/", "\\\\$1", $string);
        }

        return $string;
    }

    protected function getBoolean($value, $default = false)
    {
        $val = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if (null === $val) {
            $val = $default;
        }

        return $val;
    }

    /**
     * Define the various smarty plugins handled by this class
     *
     * @return \TheliaSmarty\Template\SmartyPluginDescriptor[] an array of smarty plugin descriptors
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor('function', 'intl', $this, 'translate'),
            new SmartyPluginDescriptor('function', 'default_translation_domain', $this, 'setDefaultTranslationDomain'),
            new SmartyPluginDescriptor('function', 'default_locale', $this, 'setDefaultLocale'),
        );
    }
}
