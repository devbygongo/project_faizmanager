<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SectorModel;
use App\Models\SubSectorModel;
use App\Models\User;

class ViewController extends Controller
{
    //

    public function users()
    {
        $get_all_users = User::all();

        if (isset($get_all_users) && (!$get_all_users->isEmpty())) 
        {
            return response()->json([
                'message' => 'User Fetched Successfully!',
                'data' => $get_all_users,
                'total_records' => count($get_all_users),
            ], 200);
        }

        else
        {
            return response()->json([
                'message' => 'Sorry, failed to fetched records!',
                'data' => 'Error'
            ], 404);
        }
    }

    public function sector()
    {
        $get_all_sector = SectorModel::all();

        if (isset($get_all_sector) && (!$get_all_sector->isEmpty())) 
        {
            return response()->json([
                'message' => 'Sector Fetched Successfully!',
                'data' => $get_all_sector,
                'total_records' => count($get_all_sector),
            ], 200);
        }

        else
        {
            return response()->json([
                'message' => 'Sorry, failed to fetched records!',
                'data' => 'Error'
            ], 404);
        }
    }

    public function subsectors()
    {
        $get_all_sub_sector = SubSectorModel::all();

        if (isset($get_all_sub_sector) && (!$get_all_sub_sector->isEmpty())) 
        {
            return response()->json([
                'message' => 'Sub-Sector records Fetched Successfully!',
                'data' => $get_all_sub_sector,
                'total_records' => count($get_all_sub_sector),
            ], 200);
        }

        else
        {
            return response()->json([
                'message' => 'Sorry, failed to fetched records!',
                'data' => 'Error'
            ], 404);
        }
    }
}
