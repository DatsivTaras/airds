<?php

namespace App\Services;

use App\Models\Aircrafts;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class AircraftServices
 */
class AircraftServices
{
    public static function deleteAircraft(int $id)
    {
        if ($aircraft = Aircrafts::find($id)) {

            DB::beginTransaction();
            try{
                $aircraft->delete();

                DB::commit();
            } catch(Exception $e){
                DB::rollback();
                throw new Exception($e->getMessage());
            }
        }
    }
}

?>
