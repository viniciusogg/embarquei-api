<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TrajetoService;

class TrajetoController extends Controller
{
    private $trajetoService;
    
    public function __construct(TrajetoService $trajetoService) 
    {
        $this->trajetoService = $trajetoService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function buscarTrajetosByCidadeInstituicaoRota($cidade, $instituicaoEnsino)
    {  
        $trajetos = $this->trajetoService->
                getTrajetosByCidadeInstituicaoRota($cidade, $instituicaoEnsino);
        
        return response()->json($trajetos, 200);
    }
}
