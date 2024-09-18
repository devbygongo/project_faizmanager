<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;
use App\Models\User;

class CSVImportController extends Controller
{
    //
    public function importUser()
    {
        // URL of the CSV file from Google Sheets
        $csvurl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSM-hjx9inHhq2KdvGOC8xf1t4ZxWPKgP3nAIm72iWg5FuQ_uC6fpN130UVeVHjzzRLkNUT7r8q8681/pub?gid=0&single=true&output=csv';

        // Fetch the CSV content using file_get_contents
        $csvContent_user = file_get_contents($csvurl);

        // Fetch and parse the CSV
        $csv = Reader::createFromPath($csvContent_user, 'r');

        // Set the header offset
        $csv->setHeaderOffset(0);

        $user_records = (new Statement())->process($csvContent_user);

        $insert_user = null;
        $update_user = null;

        foreach ($user_records as $user)
        {
            $user = User::where('mobile', $user['mobile'])->first();

            // Handle potential empty values for email, family_id, and its
            $user_email = !empty($user['email']) ? $user['email'] : null;
            $user_family_id = $user['family_id'] !== '' ? $user['family_id'] : 0;
            $user_its = $user['ITS_ID'] !== '' ? $user['ITS_ID'] : 0;

            if ($user) {
                // If user exists, update it
                $update_user = $user->update([
                    'name' => $user['Name'],
                    'email' => strtolower($user_email),
                    'password' => bcrypt($user['mobile']),
                    // 'family_id' => $user_family_id,
                    // 'title' => $user['title'],
                    'its' => $user_its,
                    'hof_its' => $user_its,
                    'family_its_id' => random_int(1000000000, 9999999999),
                    'mobile' => $user['Mobile'],
                    // 'address' => $user['address'],
                    // 'building' => $user['building'],
                    // 'flat_no' => $user['flat_no'],
                    // 'lattitude' => $user['lattitude'],
                    // 'longitude' => $user['longitude'],
                    'gender' => strtolower($user['Gender']),
                    // 'date_of_birth' => $user['date_of_birth'],
                    // 'folio_no' => $user['folio_no'],
                    // 'sector' => $user['sector'],
                    // 'sub_sector' => $user['sub_sector'],
                    // 'thali_status' => $user['thali_status'],
                    // 'status' => $user['status'],
                ]);
            }

            else {
                // If user does not exist, create a new one
                $insert_user = $user->create([
                    'name' => $user['Name'],
                    'email' => strtolower($user_email),
                    'password' => bcrypt($user['mobile']),
                    // 'family_id' => $user_family_id,
                    // 'title' => $user['title'],
                    'its' => $user_its,
                    'hof_its' => $user_its,
                    'family_its_id' => random_int(1000000000, 9999999999),
                    'mobile' => $user['Mobile'],
                    // 'address' => $user['address'],
                    // 'building' => $user['building'],
                    // 'flat_no' => $user['flat_no'],
                    // 'lattitude' => $user['lattitude'],
                    // 'longitude' => $user['longitude'],
                    'gender' => strtolower($user['Gender']),
                    // 'date_of_birth' => $user['date_of_birth'],
                    // 'folio_no' => $user['folio_no'],
                    // 'sector' => $user['sector'],
                    // 'sub_sector' => $user['sub_sector'],
                    // 'thali_status' => $user['thali_status'],
                    // 'status' => $user['status'],
                ]);
            }
        }

        if ($update_user == 1 || isset($insert_user)) {
            return response()->json(['message' => 'Users imported successfully!', 'success' => 'true'], 200);
        }
        else {
            return response()->json(['message' => 'Sorry, failed to imported successfully!', 'success' => 'false'], 400);
        }
    }
}
