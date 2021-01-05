<?php

namespace App\Controllers\backoffice;

use App\Controllers\BaseController;
// use CodeIgniter\Controller;

class Reception extends BaseController
{
    public $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        // if()
    }
    public function index()
    {
        return view('welcome_message');
    }

    //--------------------------------------------------------------------

}
