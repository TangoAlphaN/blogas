<?php

namespace blogapp\vue;
use blogapp\vue\vue;

class MembreVue extends Vue
{

    const NOUVEAU_VUE = 1;

    public function render(){
        switch($this->selecteur) {
            case self::NOUVEAU_VUE:
                $content = $this->connecte();
                break;
        }
        return $this->userPage($content);
    }

    public function connecte(){
        return <<<YOP
            <form method="post" action="{$this->cont['router']->pathFor('memb_auth')}">
                <input type="text" class="toggle-all" name="mail" placeholder="Enter your email" required><br>
                <input type="text" class="toggle-all" name="mdp_hash" placeholder="Enter your password" required><br>
                <button type="submit" value="Connexion"/>
            </form>
YOP;

    }
}
