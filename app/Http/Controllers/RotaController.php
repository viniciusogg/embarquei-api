<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RotaService;

class RotaController extends Controller
{
    private $rotaService;
    
    public function __construct(RotaService $rotaService) 
    {
        $this->rotaService = $rotaService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rotas = $this->rotaService->findAll();

        if (empty($rotas))
        {
            return response()->json('', 204);
        }

        return response()->json($rotas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rota = $request->all();

        $this->rotaService->create($rota);

        return response()->json(['response' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rota = $this->rotaService->findById($id);

        if ($rota)
        {
            return response()->json($rota->toArray(), 200);
        }

        return response()->json(['response' => 'Rota não encontrada'], 400);
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
        $rota = $request->all();

        $rotaAtualizada = $this->rotaService->update($rota, $id);

        return response()->json([$rotaAtualizada->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->rotaService->delete($id);

        return response()->json('', 204);
    }
}
