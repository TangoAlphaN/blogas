<?php

namespace blogapp\controleur;

use blogapp\modele\Billet;
use blogapp\vue\BilletVue;
use blogapp\modele\Commentaire;

class BilletControleur {
    private $cont;
    
    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function affiche($rq, $rs, $args) {
        $id = $args['id'];
        $billet = Billet::where('id', '=', $id)->first();

        $bl = new BilletVue($this->cont, $billet, BilletVue::BILLET_VUE, $billet->id);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function liste($rq, $rs, $args) {
        $numPage = $args['numpage'];
        $billets = Billet::orderBy('date', 'DESC')->skip(20*($numPage-1))->take(20)->get();

        $bl = new BilletVue($this->cont, $billets, BilletVue::LISTE_VUE, $numPage);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function ajoute($rq, $rs, $args){
        $content = filter_var($rq->getParsedBodyParam('commentaire'), FILTER_SANITIZE_STRING);
        $billet = $args['id'];
        $auteur = $_COOKIE['membre_authentifier'];

        $commentaire = new Commentaire();
        $commentaire->content = $content;
        $commentaire->billet = $billet;
        $commentaire->auteur = $auteur;
        $commentaire->date = date("Y-m-d");
        $commentaire->save();

        $this->cont->flash->addMessage('info', "Bill posted :)");
        return $rs->withRedirect($this->cont->router->pathFor('billet_aff', ['id' => $billet]));
    }
}
