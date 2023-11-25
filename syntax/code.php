<?php
/**
 * DokuPrism Plugin - Code highlighter using [prismjs.com] library
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author Adam Mnemnonic <adam85mn@gmail.com>
 */
if (!defined('DOKU_INC')) die();


/**
 * All DokuWiki plugins to extend the parser/rendering mechanism need to inherit from this class
 */
class syntax_plugin_dokuprism_code extends DokuWiki_Syntax_Plugin {

    function getType() {
        return 'protected';
    }

    function getSort() {
        return 199;  // <-- native 'code'/'file' sort=200
    }

    public function preConnect() {
        $this->mode = substr(get_class($this), 7); // syntax mode, drop 'syntax_' from class name

        $this->pattern[1] = '<file\b.*?>(?=.*?</file>)';
        $this->pattern[2] = '</file>';

        $this->pattern[11] = '<code\b.*?>(?=.*?</code>)';
        $this->pattern[12] = '</code>';
    }

    public function connectTo($mode)
    {
        if ($this->getConf('override_file')) $this->Lexer->addEntryPattern($this->pattern[1],  $mode, $this->mode);
        if ($this->getConf('override_code')) $this->Lexer->addEntryPattern($this->pattern[11], $mode, $this->mode);
    }

    public function postConnect()
    {
        if ($this->getConf('override_file')) $this->Lexer->addExitPattern($this->pattern[2],  $this->mode);
        if ($this->getConf('override_code')) $this->Lexer->addExitPattern($this->pattern[12], $this->mode);
    }


    function handle($match, $state, $pos, Doku_Handler $handler){
        switch ($state) {
            case DOKU_LEXER_ENTER:
                $match = trim(substr($match, 5, -1)); //5 = strlen("<code")
                break;
        }
        return array($match, $state, $pos);
    }




    function render($format, Doku_Renderer $renderer, $data) {
        list($match, $state, $pos) = $data;
        if($format == 'xhtml'){
            switch ($state) {
                case DOKU_LEXER_ENTER:
                    $language = $renderer->_xmlEntities($match);
                    $renderer->doc .= '<pre class="plain"><code class="language-'.$language.'">';
                    break;
                case DOKU_LEXER_UNMATCHED:
                    $renderer->doc .= trim($renderer->_xmlEntities($match));
                    break;
                case DOKU_LEXER_EXIT:
                    $renderer->doc .= '</code></pre>';
                    break;
                case DOKU_LEXER_MATCHED:
                case DOKU_LEXER_SPECIAL:
                    break;
            }
            return true;
        }
        return false;
    }
}
?>
