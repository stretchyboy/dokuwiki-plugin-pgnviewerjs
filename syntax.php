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
      $this->Lexer->addEntryPattern('<pgn.*?>',$mode,'plugin_pgnviewerjs'); 
    }
    
    function postConnect()
    {
      $this->Lexer->addExitPattern('</pgn>','plugin_pgnviewerjs');
    }


    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        switch ($state) {
          case DOKU_LEXER_ENTER :
              $aDefaults = array(
                'pieceSet'=> "merida",   
                'pieceSize'=> 46,
              );
              $aBoard = array();
              parse_str(trim(str_replace(array('<pgn','>'),'',$match)), $aBoard);
              $this->aBoard = array_merge($aDefaults, $aBoard);
              
            return array($state, $match);
          case DOKU_LEXER_UNMATCHED :
            $this->aBoard['pgnString'] = str_replace("\n", " ",$match); 
            
            return array($state, $this->aBoard);
          case DOKU_LEXER_EXIT :   
            return array($state, '');
        }
        return array();
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
        $renderer->nocache();

        if($mode == 'xhtml'){
            list($state,$aBoard) = $data;
            switch ($state) {
              case DOKU_LEXER_ENTER :
                if(!isset($renderer->pgnviewer_board))
                {
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
                  </link>';
                  $renderer->pgnviewer_board = 0;
                }
                $renderer->pgnviewer_board ++;
                
  #render out the json
                break;
                
              case DOKU_LEXER_UNMATCHED :  
                #render the pgnString
                
                if($aBoard)
                {
                  if(!isset($aBoard['boardName']))
                  {
                    $aBoard['boardName'] = 'pgn_board_'.$renderer->pgnviewer_board;
                  }
            
                  $renderer->doc .= "<script>  new PgnViewer(".json_encode($aBoard)."); </script>";  
                  $renderer->doc .= '<div class="pgn-viewer">
                  <div class="pgn-container" id="'.$aBoard['boardName'].'-container"></div>  
                  <div class="pgn-moves" id="'.$aBoard['boardName'].'-moves"></div>
                  </div> 
                  
                  <div class="pgn-credit">
                  <a href="http://chesstempo.com">http://chesstempo.com</a>
                  </div>
                  <div class="clearer"></div>';    
                }
                break;
              case DOKU_LEXER_EXIT :
                break;
            }
            return true;
        }
        return false;
    }
}
?>