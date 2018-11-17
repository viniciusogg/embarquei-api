<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HorarioTrajetoService;

class HorarioTrajetoController extends Controller
{
    private $horarioTrajetoService;
    
    public function __construct(HorarioTrajetoService $horarioTrajetoService) 
    {
        $this->horarioTrajetoService = $horarioTrajetoService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horariosTrajeto = $this->horarioTrajetoService->findAll();

        if (empty($horariosTrajeto))
        {
            return response()->json('', 204);
        }

        return response()->json($horariosTrajeto, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $horarioTrajeto = $request->all();

        $this->horarioTrajetoService->create($horarioTrajeto);

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
        $horarioTrajeto = $this->horarioTrajetoService->findById($id);

        if ($horarioTrajeto)
        {
            return response()->json($horarioTrajeto->toArray(), 200);
        }

        return response()->json(['response' => 'Horario do trajeto não encontrado'], 400);
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
        $horarioTrajeto = $request->all();

        $horarioTrajetoAtualizado = $this->horarioTrajetoService->update($horarioTrajeto, $id);
        
        return response()->json([$horarioTrajetoAtualizado->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->horarioTrajetoService->delete($id);

        return response()->json('', 204);
    }
}
