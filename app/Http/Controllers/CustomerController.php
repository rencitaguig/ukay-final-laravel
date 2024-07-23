<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Customer::orderBy('user_id', 'DESC')->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User([
            'username' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->input('password')),
            'role' => "customer",
            "status" => "activated",
        ]);
        $user->save();

        $customer = new Customer();
        $customer->user_id = $user->id;

        $customer->last_name = $request->last_name;
        $customer->first_name = $request->first_name;
        $customer->address = $request->address;
        $customer->phone_number = $request->phone_number;
        $files = $request->file('uploads');
        $customer->image_path = 'storage/images/' . $files->getClientOriginalName();
        $customer->save();
        $data = ['status' => 'saved'];
        Storage::put(
            'public/images/' . $files->getClientOriginalName(),
            file_get_contents($files)
        );

        return response()->json([
            "success" => "Customer Created Successfully.",
            "customer" => $customer,
            "status" => 200
        ]);
    }

//     public function store(Request $request)
// {
//     // Create a new user
//     $user = new User([
//         'username' => $request->first_name . ' ' . $request->last_name,
//         'email' => $request->email,
//         'password' => bcrypt($request->input('password')),
//         'role' => "customer",
//         "status" => "activated",
//     ]);
//     $user->save();

//     // Create a new customer record
//     $customer = new Customer();
//     $customer->user_id = $user->id;
//     $customer->last_name = $request->last_name;
//     $customer->first_name = $request->first_name;
//     $customer->address = $request->address;
//     $customer->phone_number = $request->phone_number;

//     // Handle single image upload
//     if ($request->hasFile('upload')) {
//         $file = $request->file('upload');
        
//         // Store the file with its original name in storage/app/public/images
//         $fileName = $file->getClientOriginalName();
//         $file->storeAs('public/images', $fileName);

//         // Set the image_path attribute of the customer
//         $customer->image_path = 'storage/images/' . $fileName;
//     }

//     // Save the customer record
//     $customer->save();

//     return response()->json([
//         "success" => "Customer Created Successfully.",
//         "customer" => $customer,
//         "status" => 200
//     ]);
// }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with('user')->where('user_id', $id)->first();
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::where('user_id', $id)->first();
        $user = User::where('id', $customer->user_id)->first();
        // dd($request->email);
        $customer->last_name = $request->last_name;
        $customer->first_name = $request->first_name;
        $customer->address = $request->address;
        $customer->zip_code = $request->zip_code;
        $customer->phone_number = $request->phone_number;
        $files = $request->file('uploads');
        $customer->image_path = 'storage/images/' . $files->getClientOriginalName();
        $customer->save();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();


        Storage::put(
            'public/images/' . $files->getClientOriginalName(),
            file_get_contents($files)
        );

        return response()->json([
            "success" => "customer update successfully.",
            "customer" => $customer,
            "status" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
		$data = array('success' => 'deleted','code'=>200);
        return response()->json($data);
    }
}
