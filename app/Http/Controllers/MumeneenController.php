<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ItsModel;
use App\Models\SectorModel;
use App\Models\SubSectorModel;
use App\Models\BuildingModel;
use App\Models\YearModel;
use App\Models\MenuModel;
use App\Models\FcmModel;
use App\Models\HubModel;
use App\Models\ZabihatModel;
use Hash;

class MumeneenController extends Controller
{
    //
    //register user
    public function register_users(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|string',
            'family_id' => 'required|string|max:10',
            'its' => 'required|unique:users,its|max:8',
            'hof_its' => 'required|string|max:8',
            'its_family_id' => 'nullable|string|max:10',
            'mobile' => ['required', 'string', 'min:12', 'max:20', 'unique:users,mobile'],
            'gender' => 'required|in:male,female',
            'title' => 'nullable|in:Shaikh,Mulla',
            'folio_no' => 'nullable|string|max:20',
            'sector' => 'nullable|string|max:100',
            'sub_sector' => 'nullable|string|max:100',
            'building' => 'nullable|integer',
            'age' => 'nullable|integer',
            'role' => 'required|in:superadmin,jamiat_admin,mumeneen',
            'status' => 'required|in:active,inactive',
        ]);

        $register_user = User::create([
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'family_id' => $request->input('family_id'),
            'its' => $request->input('its'),
            'hof_its' => $request->input('hof_its'),
            'its_family_id' => $request->input('its_family_id'),
            'mobile' => $request->input('mobile'),
            'title' => $request->input('title'),
            'gender' => $request->input('gender'),
            'age' => $request->input('age'),
            'building' => $request->input('building'),
            'folio_no' => $request->input('folio_no'),
            'sector' => $request->input('sector'),
            'sub_sector' => $request->input('sub_sector'),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
        ]);

        unset($register_user['id'], $register_user['created_at'], $register_user['updated_at']);
    
        return isset($register_user) && $register_user !== null
        ? response()->json(['User created successfully!', 'data' => $register_user], 201)
        : response()->json(['Failed to create successfully!'], 400);
    }

    // view
    public function users()
    {
        $get_all_users = User::select('name', 'email', 'jamiat_id', 'family_id', 'mobile', 'its', 'hof_its', 'its_family_id', 'folio_no', 'mumeneen_type', 'title', 'gender', 'age', 'building', 'sector', 'sub_sector', 'status', 'role', 'username');

        return isset($get_all_users) && $get_all_users->isNotEmpty()
            ? response()->json(['User Fetched Successfully!', 'data' => $get_all_users], 200)
            : response()->json(['Sorry, failed to fetched records!'], 404);
    }

    // update
    public function update_record(Request $request, $id)
    {
        // Fetch the record by ID
        $get_user = User::where('its', $id)->first();

        // Check if the record exists
        if (!$get_user) {
            return response()->json([
                'message' => 'Record not found!',
            ], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|string',
            'family_id' => 'required|string|max:10',
            'its' => 'required|unique:users,its|max:8',
            'hof_its' => 'required|string|max:8',
            'its_family_id' => 'nullable|string|max:10',
            'mobile' => ['required', 'string', 'min:12', 'max:20', 'unique:users,mobile'],
            'gender' => 'required|in:male,female',
            'title' => 'nullable|in:Shaikh,Mulla',
            'folio_no' => 'nullable|string|max:20',
            'sector' => 'nullable|string|max:100',
            'sub_sector' => 'nullable|string|max:100',
            'building' => 'nullable|integer',
            'age' => 'nullable|integer',
            'role' => 'required|in:superadmin,jamiat_admin,mumeneen',
            'status' => 'required|in:active,inactive',
        ]);

        $update_user_record = $get_user->update([
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'family_id' => $request->input('family_id'),
            'its' => $request->input('its'),
            'hof_its' => $request->input('hof_its'),
            'its_family_id' => $request->input('its_family_id'),
            'mobile' => $request->input('mobile'),
            'title' => $request->input('title'),
            'gender' => $request->input('gender'),
            'age' => $request->input('age'),
            'building' => $request->input('building'),
            'folio_no' => $request->input('folio_no'),
            'sector' => $request->input('sector'),
            'sub_sector' => $request->input('sub_sector'),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
        ]);

        return ($update_user_record == 1)
        ? response()->json(['message' => 'Record updated Successfully!', 'data' => $update_user_record], 200)
        : response()->json(['No changes detected'], 304);
    }

    // delete
    public function delete_user($id)
    {
        // Delete the fabrication
        $delete_user = User::where('id', $id)->delete();

        // Return success response if deletion was successful
        return $delete_user
        ? response()->json(['message' => 'Delete User Record successfully!'], 200)
        : response()->json(['message' => 'Sorry, Record not found'], 404);
    }

    // create
    public function register_its(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'hof_its' => 'required|integer',
            'its_family_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|unique:mumeneens,email',
            'mobile' => ['required', 'string', 'min:12', 'max:20', 'unique:mumeneens,mobile'],
            'title' => 'nullable|in:Shaikh,Mulla',
            'mumeneen_type' => 'required|in:HOF,FM',
            'gender' => 'required|in:male,female',
            'age' => 'nullable|integer',
            'sector' => 'nullable|integer',
            'sub_sector' => 'nullable|integer',
            'name_arabic' => 'nullable|string',
        ]);

        $register_its = ItsModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'hof_its' => $request->input('hof_its'),
            'its_family_id' => $request->input('its_family_id'),
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'mobile' => $request->input('mobile'),
            'title' => $request->input('title'),
            'mumeneen_type' => $request->input('mumeneen_type'),
            'gender' => $request->input('gender'),
            'age' => $request->input('age'),
            'sector' => $request->input('sector'),
            'sub_sector' => $request->input('sub_sector'),
            'name_arabic' => $request->input('name_arabic'),
        ]);

        return $register_its
            ? response()->json(['message' => 'Its registered successfully!', 'data' => $register_its], 201)
            : response()->json(['message' => 'Failed to register Its!'], 400);
    }

    // view
    public function all_its()
    {
        $get_all_mumeneens = ItsModel::select('jamiat_id', 'hof_its', 'its_family_id', 'name', 'email', 'mobile', 'title', 'mumeneen_type', 'gender', 'age', 'sector', 'sub_sector', 'name_arabic')->get();

        return $get_all_mumeneens->isNotEmpty()
            ? response()->json(['message' => 'Mumeneen records fetched successfully!', 'data' => $get_all_mumeneens], 200)
            : response()->json(['message' => 'No Mumeneen records found!'], 404);
    }

    // update
    public function update_its(Request $request, $id)
    {
        $get_its = ItsModel::find($id);

        if (!$get_its) {
            return response()->json(['message' => 'Mumeneen record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'hof_its' => 'required|integer',
            'its_family_id' => 'required|integer',
            'name' => 'required|string',
            // 'email' => 'required|unique:mumeneens,email,'.$id, // Ignore the current record's email during validation
            'email' => 'required',
            // 'mobile' => ['required', 'string', 'min:12', 'max:20', 'unique:mumeneens,mobile,'.$id], // Ignore current mobile
            'mobile' => ['required', 'string', 'min:12', 'max:20'],
            'title' => 'nullable|in:Shaikh,Mulla',
            'mumeneen_type' => 'required|in:HOF,FM',
            'gender' => 'required|in:male,female',
            'age' => 'nullable|integer',
            'sector' => 'nullable|integer',
            'sub_sector' => 'nullable|integer',
            'name_arabic' => 'nullable|string',
        ]);

        $update_its_record = $get_its->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'hof_its' => $request->input('hof_its'),
            'its_family_id' => $request->input('its_family_id'),
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'mobile' => $request->input('mobile'),
            'title' => $request->input('title'),
            'mumeneen_type' => $request->input('mumeneen_type'),
            'gender' => $request->input('gender'),
            'age' => $request->input('age'),
            'sector' => $request->input('sector'),
            'sub_sector' => $request->input('sub_sector'),
            'name_arabic' => $request->input('name_arabic'),
        ]);

        return $update_its_record
            ? response()->json(['message' => 'Its record updated successfully!', 'data' => $update_its_record], 200)
            : response()->json(['message' => 'No changes detected!'], 304);
    }

    // delete
    public function delete_its($id)
    {
        $delete_its = ItsModel::where('id', $id)->delete();

        return $delete_its
            ? response()->json(['message' => 'Its record deleted successfully!'], 200)
            : response()->json(['message' => 'Its record not found!'], 404);
    }

    // create
    public function register_sector(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'name' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'log_user' => 'required|string|max:100',
        ]);

        $register_sector = SectorModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'name' => $request->input('name'),
            'notes' => $request->input('notes'),
            'log_user' => $request->input('log_user'),
        ]);

        return $register_sector
            ? response()->json(['message' => 'sector created successfully!', 'data' => $register_sector], 201)
            : response()->json(['message' => 'Failed to create sector!'], 400);
    }

    // view
    public function all_sector()
    {
        $get_all_sector = SectorModel::select('jamiat_id', 'name', 'notes', 'log_user')->get();

        return $get_all_sector->isNotEmpty()
            ? response()->json(['message' => 'Sector records fetched successfully!', 'data' => $get_all_sector], 200)
            : response()->json(['message' => 'No Sector records found!'], 404);
    }

    // update
    public function update_jamiat(Request $request, $id)
    {
        $get_sector = SectorModel::find($id);

        if (!$get_sector) {
            return response()->json(['message' => 'Sector record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'name' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'log_user' => 'required|string|max:100',
        ]);

        $update_sector_record = $get_sector->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'name' => $request->input('name'),
            'notes' => $request->input('notes'),
            'log_user' => $request->input('log_user'),
        ]);

        return $update_sector_record
            ? response()->json(['message' => 'Sector record updated successfully!', 'data' => $update_sector_record], 200)
            : response()->json(['No changes detected!'], 304);
    }

    // delete
    public function delete_sector($id)
    {
        $delete_sector = SectorModel::where('id', $id)->delete();

        return $delete_sector
            ? response()->json(['message' => 'Sector record deleted successfully!'], 200)
            : response()->json(['message' => 'Sector record not found!'], 404);
    }

    // create
    public function register_sub_sector(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'sector' => 'required|integer',
            'name' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'log_user' => 'required|string|max:100',
        ]);

        $register_sub_sector = SubSectorModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'sector' => $request->input('sector'),
            'name' => $request->input('name'),
            'notes' => $request->input('notes'),
            'log_user' => $request->input('log_user'),
        ]);

        return $register_sub_sector
            ? response()->json(['message' => 'Sub-Sector created successfully!', 'data' => $register_sub_sector], 201)
            : response()->json(['message' => 'Failed to create sub-sector!'], 400);
    }

    // view
    public function all_sub_sector()
    {
        $get_all_sub_sector = SubSectorModel::select('jamiat_id', 'sector', 'name', 'notes', 'log_user')->get();

        return $get_all_sub_sector->isNotEmpty()
            ? response()->json(['message' => 'Sub-Sector records fetched successfully!', 'data' => $get_all_sub_sector], 200)
            : response()->json(['message' => 'No sub-sector records found!'], 404);
    }

    // update
    public function update_sub_sector(Request $request, $id)
    {
        $get_sub_sector = SubSectorModel::find($id);

        if (!$get_sub_sector) {
            return response()->json(['message' => 'Sub-Sector record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'sector' => 'required|integer',
            'name' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'log_user' => 'required|string|max:100',
        ]);

        $update_sub_sector_record = $get_sub_sector->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'sector' => $request->input('sector'),
            'name' => $request->input('name'),
            'notes' => $request->input('notes'),
            'log_user' => $request->input('log_user'),
        ]);

        return $update_sub_sector_record
            ? response()->json(['message' => 'Sub-Sector record updated successfully!', 'data' => $update_sub_sector_record], 200)
            : response()->json(['No changes detected!'], 304);
    }

    // delete
    public function delete_sub_sector($id)
    {
        $delete_sub_sector = SubSectorModel::where('id', $id)->delete();

        return $delete_sub_sector
            ? response()->json(['message' => 'Sub-Sector record deleted successfully!'], 200)
            : response()->json(['message' => 'Sub-Sector record not found!'], 404);
    }

    // create
    public function register_building(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'address_lime_1' => 'nullable|string|max:255',
            'address_lime_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:100',
            'lattitude' => 'nullable|string|max:100',
            'longtitude' => 'nullable|string|max:100',
            'landmark' => 'nullable|string|max:255',
        ]);

        $register_building = BuildingModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'name' => $request->input('name'),
            'address_lime_1' => $request->input('address_lime_1'),
            'address_lime_2' => $request->input('address_lime_2'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'state' => $request->input('state'),
            'lattitude' => $request->input('lattitude'),
            'longtitude' => $request->input('longtitude'),
            'landmark' => $request->input('landmark'),
        ]);

        return $register_building
            ? response()->json(['message' => 'Building  created successfully!', 'data' => $register_building], 201)
            : response()->json(['message' => 'Failed to create Building!'], 400);
    }

    // view
    public function all_building()
    {
        $get_all_building = BuildingModel::select('jamiat_id', 'name', 'address_lime_1', 'address_lime_2', 'city', 'pincode', 'state', 'lattitude', 'longtitude', 'landmark')->get();

        return $get_all_building->isNotEmpty()
            ? response()->json(['message' => 'Building fetched successfully!', 'data' => $get_all_building], 200)
            : response()->json(['message' => 'No building records found!'], 404);
    }

    // update
    public function update_building(Request $request, $id)
    {
        $get_building = BuildingModel::find($id);

        if (!$get_building) {
            return response()->json(['message' => 'Building record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'address_lime_1' => 'nullable|string|max:255',
            'address_lime_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:100',
            'lattitude' => 'nullable|string|max:100',
            'longtitude' => 'nullable|string|max:100',
            'landmark' => 'nullable|string|max:255',
        ]);

        $update_building = $get_building->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'name' => $request->input('name'),
            'address_lime_1' => $request->input('address_lime_1'),
            'address_lime_2' => $request->input('address_lime_2'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'state' => $request->input('state'),
            'lattitude' => $request->input('lattitude'),
            'longtitude' => $request->input('longtitude'),
            'landmark' => $request->input('landmark'),
        ]);

        return $update_building
            ? response()->json(['message' => 'Building fetchedted successfully!', 'data' => $update_building], 200)
            : response()->json(['No changes detected!'], 304);
    }

    // delete
    public function delete_building($id)
    {
        $delete_building = BuildingModel::where('id', $id)->delete();

        return $delete_building
            ? response()->json(['message' => 'Building  record deleted successfully!'], 200)
            : response()->json(['message' => 'Building  record not found!'], 404);
    }

    // create
    public function register_year(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:10',
            'jamiat_id' => 'required|integer',
            'is_current' => 'required|in:0,1',
        ]);

        $register_year = YearModel::create([
            'year' => $request->input('year'),
            'jamiat_id' => $request->input('jamiat_id'),
            'is_current' => $request->input('is_current'),
        ]);

        return $register_year
            ? response()->json(['message' => 'Year created successfully!', 'data' => $register_year], 201)
            : response()->json(['message' => 'Failed to create year!'], 400);
    }

    // view
    public function all_years()
    {
        $get_all_years = YearModel::select('year', 'jamiat_id', 'is_current')->get();

        return $get_all_years->isNotEmpty()
            ? response()->json(['message' => 'Year records fetched successfully!', 'data' => $get_all_years], 200)
            : response()->json(['message' => 'No year records found!'], 404);
    }

    // update
    public function update_year(Request $request, $id)
    {
        $get_year = YearModel::find($id);

        if (!$get_year) {
            return response()->json(['message' => 'Year record not found!'], 404);
        }

        $request->validate([
            'year' => 'required|string|max:10',
            'jamiat_id' => 'required|integer',
            'is_current' => 'required|in:0,1',
        ]);

        $update_year_record = $get_year->update([
            'year' => $request->input('year'),
            'jamiat_id' => $request->input('jamiat_id'),
            'is_current' => $request->input('is_current'),
        ]);

        return $update_year_record
            ? response()->json(['message' => 'Year updated successfully!', 'data' => $update_year_record], 200)
            : response()->json(['No changes detected!'], 304);
    }

    // delete
    public function delete_year($id)
    {
        $delete_year = YearModel::where('id', $id)->delete();

        return $delete_year
            ? response()->json(['message' => 'Year record deleted successfully!'], 200)
            : response()->json(['message' => 'Year record not found!'], 404);
    }


    // create
    public function register_menu(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'family_id' => 'nullable|integer',
            'date' => 'required|date',
            'menu' => 'required|string|max:255',
            'addons' => 'required|string|max:255',
            'niaz_by' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'slip_names' => 'required|string|max:255',
            'category' => 'required|in:chicken,mutton,veg,dal,zabihat',
            'status' => 'required|string|max:255',
        ]);

        $register_menu = MenuModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'family_id' => $request->input('family_id'),
            'date' => $request->input('date'),
            'menu' => $request->input('menu'),
            'addons' => $request->input('addons'),
            'niaz_by' => $request->input('niaz_by'),
            'year' => $request->input('year'),
            'slip_names' => $request->input('slip_names'),
            'category' => $request->input('category'),
            'status' => $request->input('status'),
        ]);

        return $register_menu
            ? response()->json(['message' => 'Menu created successfully!', 'data' => $register_menu], 201)
            : response()->json(['message' => 'Failed to create menu!'], 400);
    }

    // view
    public function all_menu()
    {
        $get_all_menus = MenuModel::select('jamiat_id', 'family_id', 'date', 'menu', 'addons', 'niaz_by', 'year', 'slip_names', 'category', 'status')->get();

        return $get_all_menus->isNotEmpty()
            ? response()->json(['message' => 'Menus fetched successfully!', 'data' => $get_all_menus], 200)
            : response()->json(['message' => 'No menu records found!'], 404);
    }

    // update
    public function update_menu(Request $request, $id)
    {
        $get_menu = MenuModel::find($id);

        if (!$get_menu) {
            return response()->json(['message' => 'Menu record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'family_id' => 'nullable|integer',
            'date' => 'required|date',
            'menu' => 'required|string|max:255',
            'addons' => 'required|string|max:255',
            'niaz_by' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'slip_names' => 'required|string|max:255',
            'category' => 'required|in:chicken,mutton,veg,dal,zabihat',
            'status' => 'required|string|max:255',
        ]);

        $update_menu_record = $get_menu->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'family_id' => $request->input('family_id'),
            'date' => $request->input('date'),
            'menu' => $request->input('menu'),
            'addons' => $request->input('addons'),
            'niaz_by' => $request->input('niaz_by'),
            'year' => $request->input('year'),
            'slip_names' => $request->input('slip_names'),
            'category' => $request->input('category'),
            'status' => $request->input('status'),
        ]);

        return $update_menu_record
            ? response()->json(['message' => 'Menu updated successfully!', 'data' => $update_menu_record], 200)
            : response()->json(['No changes detected!'], 304);
    }

    // delete
    public function delete_menu($id)
    {
        $delete_menu = MenuModel::where('id', $id)->delete();

        return $delete_menu
            ? response()->json(['message' => 'Menu record deleted successfully!'], 200)
            : response()->json(['message' => 'Menu record not found!'], 404);
    }

    // create
    public function register_fcm(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'user_id' => 'required|integer',
            'fcm_token' => 'required|string', // Since it's a text field, validation is lenient
            'status' => 'required|string|max:255',
        ]);

        $register_fcm = FcmModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'user_id' => $request->input('user_id'),
            'fcm_token' => $request->input('fcm_token'),
            'status' => $request->input('status'),
        ]);

        return $register_fcm
            ? response()->json(['message' => 'FCM Token registered successfully!', 'data' => $register_fcm], 201)
            : response()->json(['message' => 'Failed to register FCM token!'], 400);
    }

    // view
    public function all_fcm()
    {
        $get_all_fcm_tokens = FcmModel::select('jamiat_id', 'user_id', 'fcm_token', 'status')->get();

        return $get_all_fcm_tokens->isNotEmpty()
            ? response()->json(['message' => 'FCM tokens fetched successfully!', 'data' => $get_all_fcm_tokens], 200)
            : response()->json(['message' => 'No FCM token records found!'], 404);
    }

    // update
    public function update_fcm(Request $request, $id)
    {
        $get_fcm_token = FcmModel::find($id);

        if (!$get_fcm_token) {
            return response()->json(['message' => 'FCM token record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'user_id' => 'required|integer',
            'fcm_token' => 'required|string',
            'status' => 'required|string|max:255',
        ]);

        $update_fcm_record = $get_fcm_token->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'user_id' => $request->input('user_id'),
            'fcm_token' => $request->input('fcm_token'),
            'status' => $request->input('status'),
        ]);

        return $update_fcm_record
            ? response()->json(['message' => 'FCM Token updated successfully!', 'data' => $update_fcm_record], 200)
            : response()->json(['No changes detected!'], 304);
    }


    // delete
    public function delete_fcm($id)
    {
        $delete_fcm_token = FcmModel::where('id', $id)->delete();

        return $delete_fcm_token
            ? response()->json(['message' => 'FCM token deleted successfully!'], 200)
            : response()->json(['message' => 'FCM token record not found!'], 404);
    }


    // create
    public function register_hub(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'family_id' => 'required|string|max:10',
            'year' => 'required|string|max:10',
            'hub_amount' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
            'log_user' => 'required|string|max:100',
        ]);

        $register_hub = HubModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'family_id' => $request->input('family_id'),
            'year' => $request->input('year'),
            'hub_amount' => $request->input('hub_amount'),
            'paid_amount' => $request->input('paid_amount'),
            'due_amount' => $request->input('due_amount'),
            'log_user' => $request->input('log_user'),
        ]);

        return $register_hub
            ? response()->json(['message' => 'Hub record created successfully!', 'data' => $register_hub], 201)
            : response()->json(['message' => 'Failed to create hub record!'], 400);
    }

    // view
    public function all_hub()
    {
        $get_all_hubs = HubModel::select('jamiat_id', 'family_id', 'year', 'hub_amount', 'paid_amount', 'due_amount', 'log_user')->get();

        return $get_all_hubs->isNotEmpty()
            ? response()->json(['message' => 'Hub records fetched successfully!', 'data' => $get_all_hubs], 200)
            : response()->json(['message' => 'No hub records found!'], 404);
    }

    // update
    public function update_hub(Request $request, $id)
    {
        $get_hub = HubModel::find($id);

        if (!$get_hub) {
            return response()->json(['message' => 'Hub record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'family_id' => 'required|string|max:10',
            'year' => 'required|string|max:10',
            'hub_amount' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
            'log_user' => 'required|string|max:100',
        ]);

        $update_hub_record = $get_hub->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'family_id' => $request->input('family_id'),
            'year' => $request->input('year'),
            'hub_amount' => $request->input('hub_amount'),
            'paid_amount' => $request->input('paid_amount'),
            'due_amount' => $request->input('due_amount'),
            'log_user' => $request->input('log_user'),
        ]);

        return $update_hub_record
            ? response()->json(['message' => 'Hub record updated successfully!', 'data' => $update_hub_record], 200)
            : response()->json(['No changes detected!'], 304);
    }

    // delete
    public function delete_hub($id)
    {
        $delete_hub = HubModel::where('id', $id)->delete();

        return $delete_hub
            ? response()->json(['message' => 'Hub record deleted successfully!'], 200)
            : response()->json(['message' => 'Hub record not found!'], 404);
    }

    // create
    public function register_zabihat(Request $request)
    {
        $request->validate([
            'jamiat_id' => 'required|integer',
            'family_id' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'zabihat_count' => 'required|integer',
            'hub_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'required|numeric',
            'log_user' => 'required|string|max:100',
        ]);

        $register_zabihat = ZabihatModel::create([
            'jamiat_id' => $request->input('jamiat_id'),
            'family_id' => $request->input('family_id'),
            'year' => $request->input('year'),
            'zabihat_count' => $request->input('zabihat_count'),
            'hub_amount' => $request->input('hub_amount'),
            'paid_amount' => $request->input('paid_amount'),
            'due_amount' => $request->input('due_amount'),
            'log_user' => $request->input('log_user'),
        ]);

        return $register_zabihat
            ? response()->json(['message' => 'Zabihat record created successfully!', 'data' => $register_zabihat], 201)
            : response()->json(['message' => 'Failed to create zabihat record!'], 400);
    }

    // view
    public function all_zabihat()
    {
        $get_all_zabihats = ZabihatModel::select('jamiat_id', 'family_id', 'year', 'zabihat_count', 'hub_amount', 'paid_amount', 'due_amount', 'log_user')->get();

        return $get_all_zabihats->isNotEmpty()
            ? response()->json(['message' => 'Zabihat records fetched successfully!', 'data' => $get_all_zabihats], 200)
            : response()->json(['message' => 'No zabihat records found!'], 404);
    }

    // update
    public function update_zabihat(Request $request, $id)
    {
        $get_zabihat = ZabihatModel::find($id);

        if (!$get_zabihat) {
            return response()->json(['message' => 'Zabihat record not found!'], 404);
        }

        $request->validate([
            'jamiat_id' => 'required|integer',
            'family_id' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'zabihat_count' => 'required|integer',
            'hub_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'required|numeric',
            'log_user' => 'required|string|max:100',
        ]);

        $update_zabihat_record = $get_zabihat->update([
            'jamiat_id' => $request->input('jamiat_id'),
            'family_id' => $request->input('family_id'),
            'year' => $request->input('year'),
            'zabihat_count' => $request->input('zabihat_count'),
            'hub_amount' => $request->input('hub_amount'),
            'paid_amount' => $request->input('paid_amount'),
            'due_amount' => $request->input('due_amount'),
            'log_user' => $request->input('log_user'),
        ]);

        return $update_zabihat_record
            ? response()->json(['message' => 'Zabihat record updated successfully!', 'data' => $update_zabihat_record], 200)
            : response()->json(['No changes detected!'], 304);
    }

    // delete
    public function delete_zabihat($id)
    {
        $delete_zabihat = ZabihatModel::where('id', $id)->delete();

        return $delete_zabihat
            ? response()->json(['message' => 'Zabihat record deleted successfully!'], 200)
            : response()->json(['message' => 'Zabihat record not found!'], 404);
    }
}
