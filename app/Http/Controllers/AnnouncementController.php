<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AnnouncementsImport;
  

use Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('id', 'DESC')->get();
        return response()->json($announcements);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date_of_arrival' => 'required',
            'description' => 'required',
            'uploads.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $announcement = new Announcement;
        $announcement->title = $request->title;
        $announcement->date_of_arrival = $request->date_of_arrival;
        $announcement->description = $request->description;
        $announcement->logo = ''; // Provide a default value

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $fileName);
                $announcement->logo .= 'storage/images/' . $fileName . ',';
            }
            $announcement->logo = rtrim($announcement->logo, ',');
        }

        $announcement->save();

        return response()->json(["success" => "Announcement created successfully.", "announcement" => $announcement, "status" => 200]);
    }

    public function show(string $id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            return response()->json($announcement);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Announcement not found."], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $announcement = Announcement::findOrFail($id);

            $request->validate([
                'title' => 'required',
                'date_of_arrival' => 'required',
                'description' => 'required',
                'uploads.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $announcement->title = $request->title;
            $announcement->date_of_arrival = $request->date_of_arrival;
            $announcement->description = $request->description;

            if ($request->hasFile('uploads')) {
                $imagePaths = [];
                foreach ($request->file('uploads') as $file) {
                    $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/images', $fileName);
                    $imagePaths[] = 'storage/images/' . $fileName;
                }
                $announcement->logo = implode(',', $imagePaths);
            }

            $announcement->save();

            return response()->json(["success" => "Announcement updated successfully.", "announcement" => $announcement, "status" => 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Announcement not found."], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();
            return response()->json(["success" => "Announcement deleted successfully.", "status" => 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Announcement not found."], 404);
        }
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'import_file' => 'required|mimes:xlsx,xls,csv'
    //     ]);
    
    //     Excel::import(new AnnouncementsImport, $request->file('import_file'));
    
    //     return response()->json(['success' => 'Announcements imported successfully.']);
    // }
    public function import (Request $request)
    {
      $request ->validate([
          'importFile' => ['required', 'file', 'mimes:xlsx,xls']
      ]);
 
      Excel::import(new AnnouncementsImport, $request->file('importFile'));
 
      return redirect()->back()->with('success', 'Announcement imported successfully');
    }
}
