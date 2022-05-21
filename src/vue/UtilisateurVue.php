<?php

namespace blogapp\vue;

use blogapp\vue\Vue;

class UtilisateurVue extends Vue {
    const NOUVEAU_VUE = 1;
    
    public function render() {
        switch($this->selecteur) {
        case self::NOUVEAU_VUE:
            $content = $this->nouveau();
            break;
        }
        return $this->userPage($content);
    }

    public function nouveau() {
        return <<<YOP
        <form method="post" action="{$this->cont['router']->pathFor('util_cree')}">
            <h1>Inscription d'un nouveau membre</h1>
                <div class="form-group">
                    <input type="text" class="toggle-all" name="pseudo" placeholder="Enter your pseudo" required><br>
                    <input type="text" class="toggle-all" name="nom" placeholder="Enter your nom" required><br>
                    <input type="text" class="toggle-all" name="prenom" placeholder="Enter your prenom" required><br>
                    <input type="text" class="toggle-all" name="mail" placeholder="Enter your mail" required><br>
                    <input type="text" class="toggle-all" name="mdp_hash" placeholder="Enter your password" required><br>
                    <input type="text" class="toggle-all" name="verification" placeholder="Enter your password again" required><br>
                    <button type="submit" value="Enregistrer"/>
                </div>
        </form>
YOP;
    }
}
