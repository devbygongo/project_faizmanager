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

    public function fetch_by_hof(Request $request)
    {
        $hofQuery = User::select('family_id', 'name', 'its', 
        // 'image_link', 
        'mobile', 'folio_no', 'sector', 'sub_sector', 'thali_status'
        // , 'current_hub', 'current_paid', 'current_due'
    );

        if($request->input('hof_its') != null)
        {
            $hofQuery->where('hof_its', $request->input('hof_its'));
        }

        if($request->input('sector') != null)
        {
            $hofQuery->where('sector', $request->input('sector'));
        }

        if($request->input('sub_sector') != null)
        {
            $hofQuery->where('sub_sector', $request->input('sub_sector'));
        }

        $get_user_records = $hofQuery->get();

        return isset($get_user_records) && $get_user_records !== null
        ? response()->json(['Fetch record successfully!', 'data' => $get_user_records, 'fetch_records' => count($get_user_records)], 200)
        : response()->json(['Sorry, failed to fetch record'], 404);
    }

    public function hof_details(Request $request)
    {
        $hofdetailsQuery = User::select('family_id', 'name', 'its', 'mobile', 'folio_no', 'sector', 'sub_sector', 'thali_status');

        if($request->input('family_id') != null)
        {
            $hofdetailsQuery->where('family_id', $request->input('family_id'));
        }

        if($request->input('hof_its') != null)
        {
            $hofdetailsQuery->where('hof_its', $request->input('hof_its'));
        }

        $get_user_details = $hofdetailsQuery->get();

        return isset($get_user_details) && $get_user_details !== null
        ? response()->json(['Fetch record successfully!', 'data' => $get_user_details, 'fetch_records' => count($get_user_details)], 200)
        : response()->json(['Sorry, failed to fetch record'], 404);
    }
}
