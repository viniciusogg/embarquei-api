<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CursoService;

class CursoController extends Controller
{
    private $cursoService;
    
    public function __construct(CursoService $cursoService) 
    {
        $this->cursoService = $cursoService;
    }

    protected function getService()
    {
        return $this->cursoService;
    }

    protected function getMensagemErro()
    {
        return 'Curso não encontrado';
    }

}
