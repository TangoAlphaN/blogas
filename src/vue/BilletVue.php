<?php

namespace blogapp\vue;
use blogapp\vue\Vue;

class BilletVue extends Vue {
    const BILLET_VUE = 1;
    const LISTE_VUE = 2;
    protected $numPage;
    
    public function render() {
        switch($this->selecteur) {
        case self::BILLET_VUE:
            $content = $this->billet();
            break;
        case self::LISTE_VUE:
            $content = $this->liste();
            break;
        default:
            break;
        }
        return $this->userPage($content);
    }

    public function __construct($cont, $src, $sel, $np) {
        $this->cont = $cont;
        $this->source = $src;
        $this->selecteur = $sel;
        $this->numPage = $np;
    }

    public function billet()
    {
        $res = "";

        if ($this->source != null) {
            $res = <<<YOP
    <h1>Affichage du billet : {$this->source->id}</h1>
    <h2>Nom : {$this->source->titre}</h2>
    <ul>
      <li>Catégorie : {$this->source->categorie->titre}</li>
      <li>Contenu : {$this->source->body}</li>
    </ul>
YOP;

            //member only
            if (isset($_COOKIE["membre_authentifier"])) {
                $urlCommentaire = $this->cont['router']->pathFor('com_ajout', ['id' => $this->numPage]);
                $res .= <<<YOP
                <form method="post" action="$urlCommentaire">
                    <textarea cols="100" rows="13" name="commentaire" maxlength="500"/>
                    <input type="submit" value="Valider"/>
                </form>
YOP;
            }

            //Displaying bill comments
            $comments = $this->source->commentaires()->get();
            if(isset($comments)) {
                foreach ($comments as $comment) {
                    $res .= <<<YOP
                        <div>
                            <p>$comment->content</p>
                            <p>Auteur : $comment->auteur, $comment->date</p>
                        </div>
YOP;
                }
            }

        } else
            $res = "<h1>Error : The bill doesn't exist !</h1>";

        return $res;
    }


    public function liste() {
        $res = "";
        
        if ($this->source != null) {
            $res = <<<YOP
    <h1>Displaying the list of tickets</h1>
    <ul>
YOP;

            foreach ($this->source as $billet) {
                $url = $this->cont->router->pathFor('billet_aff', ['id' => $billet->id]);
                $text = substr($billet->body,0,50);
                $cat =$billet->categorie;
                $bil = "$billet->titre,  $billet->date, $cat->titre,  $text";
                $res .= <<<YOP
      <li><a href="$url">{$billet->titre}</a></li>
YOP;
            }

            $res .="</ul>";
            $res .= <<<YOP
                <button onclick="window.location.href = '{$this->baseURL()}/billets/'.($this->numPage+1);">Next page</button>
YOP;
            if($this->numPage>1)
                $res .= <<<YOP
                    <button onclick="window.location.href = '{$this->baseURL()}/billets/'.($this->numPage-1);">Previous page</button>
YOP;

        }
        else
            $res = "<h1>Error : the bill list doesn't exist !</h1>";

        return $res;
    }
}
