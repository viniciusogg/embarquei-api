<?php

namespace App\Http\Controllers;

use App\Services\ListaPresencaService;
use Illuminate\Http\Request;

class ListaPresencaController extends Controller
{
    private $listaPresencaService;

    public function __construct(ListaPresencaService $listaPresencaService)
    {
        $this->listaPresencaService = $listaPresencaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listasPresenca = $this->listaPresencaService->findAll();

        if (empty($listasPresenca))
        {
            return response()->json('', 204);
        }
        return response()->json($listasPresenca, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dadosListaPresenca = $request->all();

        $listaPresencaSalvo = $this->listaPresencaService->create($dadosListaPresenca);

        return response()->json($listaPresencaSalvo->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $listaPresenca = $this->listaPresencaService->findById($id);

        if ($listaPresenca)
        {
            return response()->json($listaPresenca->toArray(), 200);
        }
        return response()->json(['response' => 'Lista de presença não encontrada'], 400);
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
        $listaPresenca = $request->all();

        $listaPresencaAtualizado = $this->listaPresencaService->update($listaPresenca, $id);

        return response()->json($listaPresencaAtualizado->toArray(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->listaPresencaService->delete($id);

        return response()->json('', 204);
    }
}
