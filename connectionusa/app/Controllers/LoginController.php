<?php

namespace App\Controllers;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends ShieldLogin
{
    public function loginView(): string|RedirectResponse
    {
        return parent::loginView();
    }

    public function loginActio(): RedirectResponse
    {
        return parent::loginAction();
    }

    public function logoutAction(): RedirectResponse
    {
        return parent::logoutAction();
    }
}
