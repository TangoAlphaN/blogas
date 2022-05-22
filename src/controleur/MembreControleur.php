<?php

namespace blogapp\controleur;
use blogapp\modele\Membre;
use blogapp\vue\MembreVue;

class MembreControleur
{
    private $cont;

    public function __construct($conteneur)
    {
        $this->cont = $conteneur;
    }

    //accéder à la page de connexion
    public function connexion($rq, $rs, $args)
    {
        $bl = new MembreVue($this->cont, null, MembreVue::NOUVEAU_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    //to disconnect
    public function deconnexion($rq, $rs, $args){
        if (isset($_COOKIE["membre_authentifier"]))
        {
            setcookie("membre_authentifier");
        }
        $this->cont->flash->addMessage('info', "disconnected successfully");
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste',['numpage' => 1]));
    }

    //member authentication
    public function authentifie($rq, $rs, $args) {
        // Récupération variable POST + nettoyage
        $mail = filter_var($rq->getParsedBodyParam('mail'), FILTER_SANITIZE_STRING);
        $password = filter_var($rq->getParsedBodyParam('mdp_hash'), FILTER_SANITIZE_STRING);

        $membre = Membre::where('mail','=',$mail)->first();
        if ($membre === null)
        {
            $this->cont->flash->addMessage('error', "Error : Wrong email");
            return $rs->withRedirect($this->cont->router->pathFor('memb_connect'));
        }
        else
        {
            $hash = $membre->mdp_hash;
            if (password_verify($password, $hash)) {
                $pseudo=$membre->pseudo;
                setcookie("membre_authentifier",$pseudo,time()+7*24*3600);
            }
            else{
                $this->cont->flash->addMessage('error', "Error : Wrong password");
                return $rs->withRedirect($this->cont->router->pathFor('memb_connect'));
            }
        }

        // Ajout d'un flash
        $this->cont->flash->addMessage('info', "User $pseudo connected !");
        // Retour de la réponse avec redirection
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste',['numpage' =>1]));
    }
}