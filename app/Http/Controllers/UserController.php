<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use Auth;
use App\Entities\User;

class UserController extends Controller
{
    private $userService;
    
    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userService->findAll();

        if (empty($users))
        {
            return response()->json('', 204);
        }

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->all();

        $this->userService->create($user);

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
        $user = $this->userService->findById($id);

        if ($user)
        {
            return response()->json($user->toArray(), 200);
        }

        return response()->json(['response' => 'Usuário não encontrado'], 400);                
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
        $user = $request->all();
        
        $userUpdated = $this->userService->update($user, $id);

        return response()->json([$userUpdated->toArray()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->delete($id);
        
        return response()->json('', 204);
    }
}
