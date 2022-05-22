<?php

namespace blogapp\vue;

class Vue {
    protected $cont;
    protected $source;
    protected $selecteur;

    public function __construct($cont, $src, $sel) {
        $this->cont = $cont;
        $this->source = $src;
        $this->selecteur = $sel;
    }

    // Méthode qui calcule la base de l'URL (nécessaire pour le bon
    // fonctionnnement des fichiers « statiques », comme styles.css)
    public function baseURL() {
        $url = $this->cont['environment']['SCRIPT_NAME'];
        $url = str_replace("/index.php", "", $url);
        return $url;
    }
    
    public function userPage($cont) {
        $flash = $this->cont->flash->getMessages();
        // Décommenter la ligne suivante pour voir la
        // structure des flashs (pour info)
        //var_dump($flash);

        if (isset($_COOKIE["membre_authentifier"]))
        {
            $boutons = <<<YOP
          <button onclick="window.location.href = '{$this->baseURL()}/deconnexion';">Log Out</button>
          <button onclick="window.location.href = '{$this->baseURL()}/newbill';">New Bill</button>
          YOP;
        }
        else
        {
            $boutons = <<<YOP
          <button onclick="window.location.href = '{$this->baseURL()}/connexion';">Log In</button>
          <button onclick="window.location.href = '{$this->baseURL()}/newutil';">Sign In</button>
          YOP;
        }


        $res = <<<YOP
         <!doctype html>
         <html>
           <head>
             <title>Application de Blog !</title>
             <link rel="stylesheet" href="{$this->baseURL()}/css/styles.css" type="text/css"/>
             <meta charset="utf-8"/>
           </head>
           <body>
           <div id=connexion>
                  $boutons
            </div>
YOP;
        // Gestion des flashs
        if ($flash) {
            foreach ($flash as $catFlash => $lesFlash) {
                $res .= <<<YOP
            <div class="flash-$catFlash">
              <ul>
YOP;
                foreach($lesFlash as $f)
                    $res .= "<li>$f</li>";

                $res .= "</ul></div>";
            }
        }
        
        $res .= <<<YOP
     $cont
   </body>
</html>
YOP;

        return $res;
    }
}
