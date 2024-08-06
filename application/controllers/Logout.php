<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Destroy the session 
        $this->session->sess_destroy();
        // Redirect to the login page or any other page you prefer 
        redirect('login');
    }
}
