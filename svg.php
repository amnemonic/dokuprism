<?php
/**
 * DokuPrism Plugin - Code highlighter using [prismjs.com] library
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author Adam Mnemnonic <adam85mn@gmail.com>
 */
$svg =  '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16">'.
        '<text y="75%" textLength="16" lengthAdjust="spacingAndGlyphs" font-size="12" >'.$_GET['label'].'</text>'.
        '</svg>';

header('Content-type: image/svg+xml');
print($svg);