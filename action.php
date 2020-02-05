<?php
/**
 * DokuPrism Plugin - Code highlighter using [prismjs.com] library
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author Adam Mnemnonic <adam85mn@gmail.com>
 */
if (!defined("DOKU_INC"))  die();

if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');


class action_plugin_dokuprism extends DokuWiki_Action_Plugin {

    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'metaheaders'); // https://www.dokuwiki.org/devel:event:tpl_metaheader_output
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
}

