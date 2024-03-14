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
            $position->created_by = \request()->header('userid');
            if(!$position->save()){
                return false;
            }

            return true;

        }catch (Exception){
            throw $e->getMessage();
        }
    }

    public function updateData($position)
    {
        try{
            $position->name = \request()->name;
            if(!$position->save()){
                return false;
            }
            return true;
        }catch(Exception $e) {
            throw $e->getMessage();
        }
    }

}
