<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\PersonalAccessToken;

class authController extends Controller
{
   public function registerUser(Request $request){
    $datauser = new User();
    $rules = [
        'name' => 'required',
        'email' => 'required',
        'role' =>  'required|exists:roles,id_role', 
        'password' => 'required|min:8',
    ];
    $validator = Validator::make($request->all(),$rules);
    if ($validator->fails()){
        return response()->json([
            'status' => 401,
            'message' => 'proses validasi gagal',
            'data' => $validator->errors()
        ], 401);
    } 
    $datauser->name = $request->name;
    $datauser->email = $request->email;
    $datauser->role = $request->role;
    $datauser->password = Hash::make($request->password);
    $datauser->save();

    return response()->json([
        'status'=>200,
        'message'=>'berhasil menambahkan akun'
    ], 200);
   }
   public function loginUser(Request $request){
    $rules = [
       
        'name' => 'required',
        'password' => 'required',
     
    ];
    $validator = Validator::make($request->all(),$rules);
    if ($validator->fails()){
        return response()->json([
            'status' => 401,
            'message' => 'proses login gagal',
            'data' => $validator->errors()
        ], 401);
    } 
    if(!Auth::attempt($request->only('name','password','role'))){
        return response()->json([
            'status'=>401,
            'message'=>'salah memasukan password atau nama',
        ],401);
    }
     $datauser = User::where('name',$request->name)->first();
    $role = User::join("roles","users.role","=","roles.id_role")
    ->where('users.id',$datauser->id)
    ->pluck('roles.name')->toArray();
    if(empty($role)){
        $role = ["*"];
    }
    
    return response()->json([
        'status'=>200,
        'message'=>'berhasil login',
        'roles' => $role,
        'token'=>$datauser->createToken('api-ticket',$role)->plainTextToken
    ]);
    
   }

   public function registerTeknisi(Request $request, Teknisi $datauser){
    $rules = [
        'fotoprofil' => 'required',
        'nama_lengkap' => 'required',
        'username' => 'required',
        'email' => 'required|email|unique:teknisis,email',
        'no_telp' => 'required|unique:teknisis,no_telp',
        'password' => 'required',
        'pic_admin' => 'required',
    ];
    $validator = Validator::make($request->all(),$rules);
    if ($validator->fails()){
        return response()->json([
            'status' => 401,
            'message' => 'proses validasi gagal',
            'data' => $validator->errors()
        ], 401);
    } 
    $datauser->fotoprofil = $request->fotoprofil;
    $datauser->nama_lengkap = $request->nama_lengkap;
    $datauser->username = $request->username;
    $datauser->email = $request->email;
    $datauser->no_telp = $request->no_telp;
    $datauser->password = Hash::make($request->password);
    $datauser->role = 2;
    $datauser->pic_admin = $request->pic_admin;
    $datauser->id_status = 2;
    $datauser->save();

    return response()->json([
        'status'=>200,
        'message'=>'berhasil menambahkan akun teknisi'
    ], 200);
   }

   public function updateTeknisi(Request $request, Teknisi $datauser, $id){
    // $datateknisi = $datauser->find($id);
    $rules = [
        'fotoprofil' => 'required',
        'nama_lengkap' => 'required',
        'username' => 'required',
        'email' => 'required|email|unique:teknisis,email',
        'no_telp' => 'required|unique:teknisis,no_telp',
        'password' => 'required',
        'pic_admin' => 'required',
        'id_status' => 'required',
    ];
    $validator = Validator::make($request->all(),$rules);
    if ($validator->fails()){
        return response()->json([
            'status' => 401,
            'message' => 'proses validasi gagal',
            'data' => $validator->errors()
        ], 401);
    } 
    $allColumn = Schema::getColumnListing($datauser->getTable());

        $data = $request->only($allColumn);

        unset($data['password']);
        unset($data['role']);

        $data['password'] = Hash::make($request->password);

        $datauser->find($id)->update($data);
    // $datateknisi->update($request->only(array_keys($rules)));

    return response()->json([
        'status'=>200,
        'message'=>'berhasil update  akun teknisi'
    ], 200);
   }

   function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        // Get User Information //
        $datauser = $token->tokenable;

        $datauser->tokens->each(function ($token) {
            $token->delete();
        });

        return response([
            'response' => 'Logged out',], 200);
    }
}
