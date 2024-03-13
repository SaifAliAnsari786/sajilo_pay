<?php

namespace App\Services;

use App\Models\Position;

/**
 * Class PositionService.
 */
class PositionService
{

    public function storeData()
    {
        try{
            $position = new Position();
            $position->name = \request()->name;
            $position->created = \request()->header('user_id');
            if(!$position->save()){
                return false;
            }

            return true;

        }catch (Exception){
            throw $e->getMessage();
        }
    }

}
