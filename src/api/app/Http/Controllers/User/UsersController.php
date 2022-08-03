<?php
 
namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Hashing\BcryptHasher;

 
class UsersController extends Controller{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
   public function __construct()
   {
	   //
   }

    //signup fn to create user with encrypted password and unique token to each user
	public function signup(Request $request){
        // Adding validation to ensure filelds are not empty
        $fields = $this->validate($request, [
            'username' => 'required|string|unique:users,email',
            'email' => 'required|string|unique:users,email',
            'password_hash' => 'required|string'
        ]);

        $fields['api_token'] = str_random(60);
        $fields['password_hash'] =  app('hash')->make($fields['password_hash']);
    	$user = User::create($fields);
    	$response = [
            'user' => $user,
            'api_token' => $user['api_token']
        ];
        return response($response, 201);
	}

    // Login if user in db and return api_token
    public function login(Request $request) {

        $fields = $this->validate($request, [
            'username' => 'required|string',
            'password_hash' => 'required|string'
        ]);

        // Check email
        $user = User::where('username', $fields['username'])->first();

        // Check password and if incorrect throw error otherwise update token
        if(!$user || !Hash::check($fields['password_hash'], $user->password_hash)) {
            return response([
                'message' => 'Wrong credentials or User not existed'
            ], 401);
        } else {
            $user->api_token=str_random(60);
            $user->save();
        }

        $response = [
            'user' => $user,
            'api_token' => $user['api_token']
        ];

        return response($response, 201);
    }

    // logout user --> delete token
    public function logout(Request $request) {

        $user = User::where('api_token', $request['api_token'])->first();
        $user->api_token='';
        $user->save();

        $response = [
            'message' => 'Successfully Logged out'
        ];
        return response($response, 200);

    } 

//Fetch an user details using toekn and returns username
    public function me(Request $request){
        $user = User::where('api_token', $request['api_token'])->first();
        $response = [
            'username' => $user['username']
        ];
        return response($response, 200);
    }

}
?>