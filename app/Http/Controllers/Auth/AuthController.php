<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\sendWhatsAppUtility;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    //register user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|string',
            'family_id' => 'required|integer',
            'its' => 'required|unique:users,its',
            'hof_its' => 'required',
            'mobile' => ['required', 'string', 'min:12', 'max:14', 'unique:users,mobile'],
            'gender' => 'required|string',
        ]);

        $register_user = User::create([
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'family_id' => $request->input('family_id'),
            'title' => $request->input('title'),
            'its' => $request->input('its'),
            'hof_its' => $request->input('hof_its'),
            'family_its_id' => $request->input('family_its_id'),
            'mobile' => $request->input('mobile'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
            'flat_no' => $request->input('flat_no'),
            'lattitude' => $request->input('lattitude'),
            'longitude' => $request->input('longitude'),
            'gender' => $request->input('gender'),
            'date_of_birth' => $request->input('date_of_birth'),
            'folio_no' => $request->input('folio_no'),
            'sector' => $request->input('sector'),
            'sub_sector' => $request->input('sub_sector'),
            'thali_status' => $request->input('thali_status'),
            'status' => $request->input('status'),
        ]);

        if (isset($register_user)) {
            return response()->json([
                'message' => 'User created successfully!',
                'data' => $register_user
            ], 201);
        }

        else {
            return response()->json([
                'message' => 'Failed to create successfully!',
                'data' => 'error'
            ], 400);
        }
    }

    // genearate otp and send to `whatsapp`
    public function generate_otp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'string', 'min:12', 'max:14'],
        ]);

        $mobile = $request->input('mobile');

        $get_user = User::select('id')
                        ->where('mobile', $mobile)
                        ->first();

        if(!$get_user == null)
        {
            $six_digit_otp = random_int(100000, 999999);

            $expiresAt = now()->addMinutes(10);

            $store_otp = User::where('mobile', $mobile)
                             ->update([
                                'otp' => $six_digit_otp,
                                'expires_at' => $expiresAt,
                            ]);

            if($store_otp)
            {
                $templateParams = [
                    'name' => 'ace_otp', // Replace with your WhatsApp template name
                    'language' => ['code' => 'en'],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $six_digit_otp,
                                ],
                            ],
                        ],
                        [
                            'type' => 'button',
                            'sub_type' => 'url',
                            "index" => "0",
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $six_digit_otp,
                                ],
                            ],
                        ]
                    ],
                ];

                $whatsappUtility = new sendWhatsAppUtility();

                $response = $whatsappUtility->sendWhatsApp($mobile, $templateParams, $mobile, 'OTP Campaign');

                return response()->json([
                    'message' => 'Otp send successfully!',
                    'data' => $store_otp
                ], 200);
            }
        }
        else {
            return response()->json([
                'message' => 'User has not registered!',
            ], 404);
        }
    }

    // user `login`
    public function login(Request $request, $otp = null)
    {
        if($otp)
        {
            $request->validate([
                'mobile' => ['required', 'string', 'size:13'],
            ]);
            
            $otpRecord = User::select('otp', 'expires_at')
            ->where('mobile', $request->mobile)
            ->first();

            if($otpRecord)
            {
                if(!$otpRecord || $otpRecord->otp != $otp)
                {
                    return response()->json(['message' => 'Sorry, invalid Otp!'], 400);
                }
                elseif ($otpRecord->expires_at < now()) {
                    return response()->json(['message' => 'Sorry, otp has expired!'], 400);
                }

                else {
                    // Remove OTP record after successful validation
                    User::select('otp')->where('mobile', $request->mobile)->update(['otp' => null, 'expires_at' => null]);

                    // Retrieve the use
                    $user = User::where('mobile', $request->mobile)->first();

                    // Generate a sanctrum token
                    $generated_token = $user->createToken('API TOKEN')->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'data' => [
                            'token' => $generated_token,
                            'name' => $user->name,
                            // 'role' => $user->role,
                        ],
                        'message' => 'User logged in successfully!',
                    ], 200);
                }
            }

            else {
                    return response()->json([
                        'success' => false,
                        'message' => 'User not register.',
                    ], 401);
            }
        }

        else {
            $request->validate([
                'mobile' => ['required', 'string', 'min:12', 'max:14'],
                'password' => 'required',
            ]);

            if(Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password]))
            {
                $user = Auth::user();

                // Generate a sanctrum token
                $generated_token = $user->createToken('API TOKEN')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'token' => $generated_token,
                        'name' => $user->name,
                        // 'role' => $user->role,
                    ],
                    'message' => 'User logged in successfully!',
                ], 200);
            }

            else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not register.',
                ], 401);
            }
        }
    }

    // user `logout`
    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if(!$request->user()) {
            return response()->json([
                'success'=> false,
                'message'=>'Sorry, no user is logged in now!',
            ], 401);
        }

        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully!',
        ], 204);
    }
}
