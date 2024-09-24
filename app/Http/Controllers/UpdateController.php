<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UpdateController extends Controller
{
    //
    public function update_record(Request $request, $id)
    {
        // Fetch the record by ID
        $get_record = User::where('its', $id)->first();

        // Check if the record exists
        if (!$get_record) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }

        $request->validate([
            'family_id' => ['required', 'integer'],
            'its' => ['required', 'integer'],
            // 'year' => ['required', 'integer'],
            'mobile' => ['required', 'string'],
            'email' => ['required', 'string'],
            'dob' => ['required', 'date'],
        ]);

        $update_user_record = $get_record->update([
            'family_id' => $request->input('family_id'),
            'its' => $request->input('its'),
            'mobile' => strtolower($request->input('mobile')),
            'email' => $request->input('email'),
            'date_of_birth' => $request->input('dob'),
        ]);

        return ($update_user_record == 1)
        ? response()->json(['message' => 'Updated Successfully!', 'data' => $update_user_record], 201)
        : response()->json(['Sorry, there were some errors in your submission'], 500);
    }
}
