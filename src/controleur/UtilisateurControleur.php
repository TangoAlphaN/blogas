<?php

namespace blogapp\controleur;

use blogapp\vue\UtilisateurVue;
use blogapp\modele\Membre;

class UtilisateurControleur {
    private $cont;
    
    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function nouveau($rq, $rs, $args) {
        $bl = new UtilisateurVue($this->cont, null, UtilisateurVue::NOUVEAU_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function cree($rq, $rs, $args) {
        // Récupération variable POST + nettoyage
        $pseudo = filter_var($rq->getParsedBodyParam('pseudo'), FILTER_SANITIZE_STRING);
        $nom = filter_var($rq->getParsedBodyParam('nom'), FILTER_SANITIZE_STRING);
        $prenom = filter_var($rq->getParsedBodyParam('prenom'), FILTER_SANITIZE_STRING);
        $mail = filter_var($rq->getParsedBodyParam('mail'), FILTER_SANITIZE_STRING);
        $mdp = filter_var($rq->getParsedBodyParam('mdp_hash'), FILTER_SANITIZE_STRING);
        $verification = filter_var($rq->getParsedBodyParam('verification'), FILTER_SANITIZE_STRING);

        // Insertion dans la base...
        $membre = new Membre();
        $membre->pseudo = $pseudo;
        $membre->nom = $nom;
        $membre->prenom = $prenom;

        // Valider email
        if(!(filter_var($mail, FILTER_VALIDATE_EMAIL))){
            $this->cont->flash->addMessage('error', "Echec : email incorrect ");
            return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        }
        else{
            $membre->mail = $mail;
        }

        // Verifier mdp
        if($mdp !== $verification){
            $this->cont->flash->addMessage('error', "Echec : mots de passe différents ");
            return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
        } else {
            $membre->mdp_hash = password_hash($mdp,PASSWORD_DEFAULT);
        }

        $membre->save();

        // Ajout d'un flash
        $this->cont->flash->addMessage('info', "Utilisateur $nom ajouté !");
        // Retour de la réponse avec redirection
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste', ['numpage' => '1']));
    }
}