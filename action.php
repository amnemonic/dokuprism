<?php
/**
 * DokuPrism Plugin - Code highlighter using [prismjs.com] library
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author Adam Mnemnonic <adam85mn@gmail.com>
 */
if (!defined("DOKU_INC"))  die();

class action_plugin_dokuprism extends DokuWiki_Action_Plugin {

    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'metaheaders'); // https://www.dokuwiki.org/devel:event:tpl_metaheader_output
        $controller->register_hook('TOOLBAR_DEFINE'       , 'AFTER' , $this, 'codeLanguageToolbar', array());
    }

    
    function metaheaders(&$event, $param) {
        // Adding a stylesheet 
        $event->data["link"][] = array (
            "type" => "text/css",
            "rel"  => "stylesheet", 
            "href" => DOKU_BASE."lib/plugins/dokuprism/prism/prism.css",
        );
        // Adding javascript
        $event->data["script"][] = array (
            "type"  => "text/javascript",
            "src"   => DOKU_BASE."lib/plugins/dokuprism/prism/prism.js",
            "_data" => "",
        );
        return true;
    }

    function codeLanguageToolbar(Doku_Event $event, $param) {
        $languages  = explode('|',$this->getConf('lanuages_list'));
        $sub_buttons = array();
        foreach($languages as $lang) {
            $sub_buttons[] = array(
                            'type'   =>  'format',
                            'title'  =>  $lang,
                            'open'   =>  "<code $lang>\n",
                            'icon'   =>  DOKU_BASE."lib/plugins/dokuprism/svg.php?label=$lang",
                            'close'  =>  "\n</code>");
        }
        
        $button = array(
                'type' => 'picker',
                'title' => $this->getLang('button_title'),
                'icon' => DOKU_REL.'lib/plugins/dokuprism/code.png',
                'list' => $sub_buttons
        );
        $event->data[] = $button;
    }
}

