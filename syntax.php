<?php
/**
 * Plugin Pgn: Sets new pgns for text and background.
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christopher Smith <chris@jalakai.co.uk>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_pgnviewerjs extends DokuWiki_Syntax_Plugin {

    function getInfo() {
      return array(
        'author' => 'Martyn Eggleton',
        'email'  => 'martyn@access-space.or',
        'date'   => '2012-05-05',
        'name'   => 'pgnviewerjs',
        'desc'   => 'renders pgn chess move format',
        'url'    => 'http://www.dokuwiki.org/plugin:pgnviewerjs',
      );
    }
  
    function getType(){ return 'formatting';}
    function getAllowedTypes() { return array('protected'); }
    
    function getSort(){ return 159; }
       
    function connectTo($mode)
    {
      $this->Lexer->addEntryPattern('<pgn.*?>(?=.*?</pgn>)',$mode,'plugin_pgnviewerjs'); 
    }
    
    function postConnect()
    {
      $this->Lexer->addExitPattern('</pgn>','plugin_pgnviewerjs');
    }


    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
      #echo "\n<br><pre>\nmatch =" .var_export($match, TRUE)."</pre>";
      #echo "\n<br><pre>\nstate =" .$state."</pre>";
      #echo "\n<br><pre>\npos =" .var_export($pos, TRUE)."</pre>";
        switch ($state) {
          case DOKU_LEXER_ENTER :
            return array($state, $match);
                #list($pgn, $background) = preg_split("/\//u", substr($match, 6, -1), 2);
                ##echo "\n<br><pre>\nmatch =" .var_export($match, TRUE)."</pre>";
                #return array($state, array($pgn, $background));

          case DOKU_LEXER_UNMATCHED :  return array($state, $match);
          case DOKU_LEXER_EXIT :       return array($state, '');
        }
        return array();
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
    // $data is what the function handle return'ed.
        if($mode == 'xhtml'){
            list($state,$match) = $data;
            //echo "\n<br><pre>\ndata =" .var_export($data, TRUE)."</pre>";
            switch ($state) {
              case DOKU_LEXER_ENTER :      
                $renderer->doc .= '<!-- Support libraries from Yahoo YUI project -->  
    <script type="text/javascript"  
        src="http://chesstempo.com/js/pgnyui.js">  
    </script>   
    <script type="text/javascript"  
        src="http://chesstempo.com/js/pgnviewer.js">  
    </script>  
    <link  
     type="text/css"   
     rel="stylesheet"   
     href="http://chesstempo.com/css/board-min.css">  
    </link> <script>  
new PgnViewer(  
  {  boardName: "demo",  
    pieceSet: "leipzig",   
    pieceSize: 46,  ';
  #render out the json
                break;
                
              case DOKU_LEXER_UNMATCHED :  
                #render the pgnString
                if($match)
                {
                  $renderer->doc .= "pgnString: '".$renderer->_xmlEntities(str_replace("\n", " ",$match))."'";
                }
                break;
              case DOKU_LEXER_EXIT :
                $renderer->doc .= '})</script>
                <div id="demo-container"></div>  
    <div id="demo-moves"></div>  '; 
                //echo "\n<br><pre>\nrenderer->doc  =" .htmlentities($renderer->doc , TRUE)."</pre>";
                break;
            }
            return true;
        }
        return false;
    }
    
}
?>