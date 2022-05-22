<?php

namespace blogapp\vue;
use blogapp\vue\vue;

class NewBillVue extends Vue
{
    const NOUVEAU_VUE = 1;

    public function render() {
        if ($this->selecteur == self::NOUVEAU_VUE) {
            $content = $this->nouveau();
        }
        return $this->userPage($content);
    }

    public function nouveau(): string
    {
        return <<<YOP
            <form method="post" action="{$this->cont['router']->pathFor('bill_cree')}">
                <h1>New Bill</h1>
                <input type="text" name="title" class="toggle-all" placeholder="Bill Title" required/><br>
                <textarea name="body" class="txtarea" cols="150" rows="100" maxlength="3000" placeholder="Bill text/content" required></textarea><br>
                <p>pick your article category :</p><br>
                <div class="choice">
                    <input type="radio" name="category" value="sport">Sport</input>
                    <input type="radio" name="category" value="cinema">Cinema</input>
                    <input type="radio" name="category" value="music">Music</input>
                    <input type="radio" name="category" value="TV">TV</input>
                    <input type="radio" name="category" value="Other">Other</input>
                </div>
                <input type="submit" name="Submit">
            </form>
YOP;

    }
}

?>