<?php

namespace App\Http\Controllers\Client;

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class EmployeeControllerClient extends Controller
{
    public function index()
    {
        //$employes = Client::all();
        $authenticatedClientId = Auth::guard('clients')->user()->id;
        $authenticatedClientSocieteId = Auth::guard('clients')->user()->id_societe;

        $employes = Client::where('id', '!=', $authenticatedClientId)
            ->where('id_societe', $authenticatedClientSocieteId)
            ->get();

        return view('client.employes', compact('employes'));
    }

    public function addEmployee(Request $request)
    {
        // Validate the request data
        $request->validate([
            //'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for image files
            // Add more validation rules for other fields if needed
        ]);
        // Create a new Client instance
        $employee = new Client();
        $employee->username = $request->input('username');
        $employee->password = $request->input('password');
        $employee->email = $request->input('email');
        $employee->name = $request->input('name');
        $employee->phone_number = $request->input('phone_number');
        $employee->type = $request->input('type');
        $employee->id_societe = $request->input('id_societe');
        $employee->adresse = $request->input('adresse');

        // Get the uploaded file
        $file = $request->file('file');
        
        // Check if a file was uploaded
        if ($file) {
            // Get the extension of the uploaded file
            $extension = $file->getClientOriginalExtension();

            // Generate a unique filename using current timestamp and extension
            $uniqueFileName = now()->format('Ymd_His') . '.' . $extension;

            // Store the file in the destination folder
            $file->storeAs('client', $uniqueFileName);

            // Assign the filename to the photo attribute of the employee
            $employee->photo = $uniqueFileName;
        }

        // Save the employee record to the database
        $employee->save();

        // Redirect back to the Employee page
        return redirect()->route('Client-Employes');
    }

    public function deleteEmployee($id)
    {
        Client::find($id)->delete();
        return redirect()->route('Client-Employes');
    }
}
