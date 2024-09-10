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
        $csvurl = '';

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
            $user_its = $user['its'] !== '' ? $user['its'] : 0;

            if ($user) {
                // If user exists, update it
                $update_user = $user->update([
                    'name' => $user['name'],
                    'email' => strtolower($user_email),
                    'password' => bcrypt($user['mobile']),
                    'family_id' => $user_family_id,
                    'title' => $user['title'],
                    'its' => $user_its,
                    'hof_its' => $user['hof_its'],
                    'family_its_id' => $user['family_its_id'],
                    'mobile' => $user['mobile'],
                    'address' => $user['address'],
                    'building' => $user['building'],
                    'flat_no' => $user['flat_no'],
                    'lattitude' => $user['lattitude'],
                    'longitude' => $user['longitude'],
                    'gender' => $user['gender'],
                    'date_of_birth' => $user['date_of_birth'],
                    'folio_no' => $user['folio_no'],
                    'sector' => $user['sector'],
                    'sub_sector' => $user['sub_sector'],
                    'thali_status' => $user['thali_status'],
                    'status' => $user['status'],
                ]);
            }

            else {
                // If user does not exist, create a new one
                $insert_user = $user->create([
                    'name' => $user['name'],
                    'email' => strtolower($user_email),
                    'password' => bcrypt($user['mobile']),
                    'family_id' => $user_family_id,
                    'title' => $user['title'],
                    'its' => $user_its,
                    'hof_its' => $user['hof_its'],
                    'family_its_id' => $user['family_its_id'],
                    'mobile' => $user['mobile'],
                    'address' => $user['address'],
                    'building' => $user['building'],
                    'flat_no' => $user['flat_no'],
                    'lattitude' => $user['lattitude'],
                    'longitude' => $user['longitude'],
                    'gender' => $user['gender'],
                    'date_of_birth' => $user['date_of_birth'],
                    'folio_no' => $user['folio_no'],
                    'sector' => $user['sector'],
                    'sub_sector' => $user['sub_sector'],
                    'thali_status' => $user['thali_status'],
                    'status' => $user['status'],
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
