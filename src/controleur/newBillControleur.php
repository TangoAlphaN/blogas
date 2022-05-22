<?php

namespace blogapp\controleur;
use blogapp\modele\Categorie;
use blogapp\modele\Billet;
use blogapp\vue\newBillVue;

class NewBillControleur
{
    private $cont;

    public function __construct($conteneur)
    {
        $this->cont = $conteneur;
    }

    public function nouveau($rq, $rs, $args) {
        $bill = new newBillVue($this->cont, null, newBillVue::NOUVEAU_VUE);
        $rs->getBody()->write($bill->render());
        return $rs;
    }

    public function saisie($rq, $rs, $args)
    {
        $title = filter_var($rq->getParsedBodyParam('title'), FILTER_SANITIZE_STRING);
        $body = filter_var($rq->getParsedBodyParam('body'), FILTER_SANITIZE_STRING);
        $category = filter_var($rq->getParsedBodyParam('category'), FILTER_SANITIZE_STRING);
        $date = date("Y-m-d");

        $categories = Categorie::get();
        foreach ($categories as $categ) {
            if ($categ->titre === $category) {
                $cat_id = $categ->id;
            }
        }

        //insert into database
        $billet = new Billet();
        $billet->titre = $title;
        $billet->body = $body;
        $billet->date = $date;
        $billet->cat_id = $cat_id;
        $billet->save();

        $this->cont->flash->addMessage('info', "Bill added successfully");
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste', ['numpage' => 1]));
    }
}