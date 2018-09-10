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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administradores = $this->adminService->findAll();

        if (empty($administradores))
        {
            return response()->json('', 204);
        }

        return response()->json($administradores, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $administrador = $request->all();

        $this->adminService->create($administrador);

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
        $administrador = $this->adminService->findById($id);

        if ($administrador)
        {
            return response()->json($administrador->toArray(), 200);
        }

        return response()->json(['response' => 'Admin não encontrado'], 400);
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
        $administrador = $request->all();

        $administradorAtualizado = $this->adminService->update($administrador, $id);

        return response()->json([$administradorAtualizado->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->adminService->delete($id);

        return response()->json('', 204);
    }
}
