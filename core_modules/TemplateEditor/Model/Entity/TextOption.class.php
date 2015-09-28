<?php

namespace Cx\Core_Modules\TemplateEditor\Model\Entity;

use Cx\Core\Core\Controller\Cx;
use Cx\Core\Html\Sigma;

/**
 * Class TextOption
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Robin Glauser <robin.glauser@comvation.com>
 * @package     contrexx
 * @subpackage  core_module_templateeditor
 */
class TextOption extends Option
{
    /**
     * The text value of the option.
     *
     * @var string
     */
    protected $string = '';

    /**
     * Regex which the string has to match
     *
     * @var String
     */
    protected $regex = null;

    /**
     * Error message which is shown if the regex doesn't match.
     *
     * @var string
     */
    protected $regexError = "";

    /**
     * @var bool
     */
    protected $html = false;

    /**
     * @param String $name
     * @param array  $translations
     * @param array  $data
     */
    public function __construct($name, $translations, $data)
    {
        parent::__construct($name, $translations, $data);
        $this->string     = isset($data['textvalue']) ? $data['textvalue'] : '';
        $this->regex      = isset($data['regex']) ? $data['regex'] : null;
        $this->html       = isset($data['html']) ? $data['html'] : false;
        $this->regexError = isset($data['regexError']) ? $data['regexError']
            : '';
    }

    /**
     * Render the option field in the backend.
     *
     * @param Sigma $template
     */
    public function renderOptionField($template)
    {
        $subTemplate = new Sigma();
        $subTemplate->loadTemplateFile(
            $this->cx->getCodeBaseCoreModulePath()
            . '/TemplateEditor/View/Template/Backend/TextOption.html'
        );
        $subTemplate->setVariable('TEMPLATEEDITOR_OPTION_VALUE', $this->string);
        $subTemplate->setVariable('TEMPLATEEDITOR_OPTION_NAME', $this->name);
        $subTemplate->setVariable(
            'TEMPLATEEDITOR_OPTION_HUMAN_NAME', $this->humanName
        );
        $template->setVariable('TEMPLATEEDITOR_OPTION', $subTemplate->get());
        $template->setVariable('TEMPLATEEDITOR_OPTION_TYPE', 'text');
        $template->parse('option');
    }

    /**
     * Render the option in the frontend.
     *
     * @param Sigma $template
     */
    public function renderTheme($template)
    {
        $template->setVariable(
            'TEMPLATE_EDITOR_' . strtoupper($this->name),
            $this->html ? $this->string : htmlentities($this->string)
        );
    }

    /**
     * Handle a change of the option.
     *
     * @param array $data
     *
     * @return array
     * @throws OptionValueNotValidException
     */
    public function handleChange($data)
    {
        global $_ARRAYLANG, $_LANGID;
        if ($this->regex && !preg_match($this->regex, $data)) {
            if (!empty($this->regexError[$_LANGID])) {
                throw new OptionValueNotValidException(
                    sprintf(
                        $this->regexError[$_LANGID],
                        $data
                    )
                );
            } elseif (!empty($this->regexError[2])) {
                throw new OptionValueNotValidException(
                    sprintf(
                        $this->regexError[2],
                        $data
                    )
                );
            }
            throw new OptionValueNotValidException(
                sprintf(
                    $_ARRAYLANG['TXT_CORE_MODULE_TEMPLATEEDITOR_TEXT_WRONG_FORMAT'],
                    $data
                ) . $this->regex
            );
        }
        $this->string = $data;
        return array('textvalue' => $this->string);
    }

    /**
     * Get the data in a serializable format.
     *
     * @return array
     */
    public function yamlSerialize()
    {
        $option             = parent::yamlSerialize();
        $option['specific'] = array(
            'regex' => $this->regex,
            'regexError' => $this->regexError,
            'html' => $this->html
        );
        return $option;
    }

    /**
     * Get the string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set the string
     *
     * @param string $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }

    /**
     * Get the regex
     *
     * @return String
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Set the regex
     *
     * @param String $regex
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    /**
     * Return if is html
     *
     * @return boolean
     */
    public function isHtml()
    {
        return $this->html;
    }

    /**
     * Set if is html
     *
     * @param boolean $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * Gets the current value of the option.
     *
     * @return array
     */
    public function getValue()
    {
        return array('textvalue' => $this->string);
    }
}
