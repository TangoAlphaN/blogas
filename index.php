<?php

// Démarrage sessions PHP
// (pour le support des variables de session)
session_start();

require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \blogapp\conf\ConnectionFactory;

// Création de la connexion à la base
ConnectionFactory::makeConnection('src/conf/conf.ini');

// Configuration de Slim

$configuration = [
    'settings' => [
        'displayErrorDetails' => true
    ],
    'flash' => function() {
        return new \Slim\Flash\Messages();
    }
];

// Création du dispatcher

$app = new \Slim\App($configuration);

// Définition des routes

// Routes qui redirige vers la liste de billets
$app->get('/',
    function ($rq,$rs,$args){
        return $rs->withRedirect($this['router']->pathFor('billet_liste'));
        })
    ->setName('billet_aff');

// Affichage d'un billet
$app->get('/billet/{id}',
          '\blogapp\controleur\BilletControleur:affiche')
    ->setName('billet_aff');

// Affichage de tous les billets
$app->get('/billets',
          '\blogapp\controleur\BilletControleur:liste')
    ->setName('billet_liste');

// Création utilisateur
$app->get('/newutil',
          '\blogapp\controleur\UtilisateurControleur:nouveau')
    ->setName('util_nouveau');

// Suite à la création utilisateur
$app->post('/createutil',
          '\blogapp\controleur\UtilisateurControleur:cree')
    ->setName('util_cree');

// Connexion d'un utilisateur
$app->post('/connexion',
    '\blogapp\controleur\MembreControleur:connexion')
    ->setName('memb_connect');

$app->post('/deconnexion',
    '\blogapp\controleur\MembreControleur:connexion')
    ->setName('memb_deconnect');

$app->post('/authentification',
    '\blogapp\controleur\MembreControleur:authentifie')
    ->setName('memb_authen');

$app->run();
