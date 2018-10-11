<?php

namespace App\Entities\Traits;

trait CriaArrayObjetoTrait 
{
    protected function retornarArrayObjetos($objetos)
    {
        $array = [];
        
        foreach ($objetos as $objeto)
        {
            $array[] = $objeto->toArray();
        }
        
        return $array;
    }
}
