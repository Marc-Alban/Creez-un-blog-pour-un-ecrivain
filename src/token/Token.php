<?php
declare (strict_types = 1);
namespace Blog\Token;

class Token
{
    private $token = null;

    /**
     * Créer les tokens
     *
     * @param [type] $session
     * @return void
     */
    public function createSessionToken(&$session): void
    {
        $this->token = bin2hex(random_bytes(32));
        $session['token'] = $this->token;
    }

    /**
     * Compare les tokens
     *
     * @param [type] $session
     * @param array $getData
     * @return string|null
     */
    public function compareTokens(&$session, array $getData): ?string
    {
        if (!isset($session['token']) || !isset($getData['post']['token']) || empty($session['token']) || empty($getData['post']['token']) || $session['token'] !== $getData['post']['token']) {
            return "Formulaire incorrect";
        }
        return null;
    }
}