<?php

namespace blogapp\modele;

class Billet extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'billets';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $titre, $body, $date, $category;

    public function categorie() {
        return $this->belongsTo('\blogapp\modele\Categorie', 'cat_id');
    }

    public function getCommentaires() {
        return $this->hasMany('\blogapp\modele\Commentaire', 'billet');
    }
}

?>
