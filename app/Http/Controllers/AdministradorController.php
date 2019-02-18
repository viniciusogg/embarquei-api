<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdministradorService;

class AdministradorController extends Controller
{
    private $adminService;
    
    public function __construct(AdministradorService $adminService) 
    {
        $this->adminService = $adminService;
    }

    protected function getService()
    {
        return $this->adminService;
    }

    protected function getMensagemErro()
    {
        return 'Admin não encontrado';
    }


}
