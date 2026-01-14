<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owners;



class OwnerControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.owners.index');
    }
    //getDatatable
    public function getDatatable(Request $request)
    {
        $owners = Owners::get();
        return datatables()->of($owners)
            ->addColumn('action', function ($owner) {
                return '<button class="btn btn-sm btn-primary edit-btn" onclick="editOwner('.$owner->id.')" data-id="'.$owner->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" onclick="deleteOwner('.$owner->id.')" data-id="'.$owner->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
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
      
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'note'    => 'nullable|string',
        ]);


           $existingOwner = Owners::where('name', $request->name)->first();
        if ($existingOwner) {
            return redirect()->back()->with('error', 'Nama owner sudah ada');
        }

        $owner = Owners::create([
            'name'    => $request->name,
            'address' => $request->address,
            'note'    => $request->note,
        ]);

        return redirect()->back()->with('success', 'Owner berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $owner = Owners::find($id);
        return response()->json($owner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $owner = Owners::find($request->id);
        if (!$owner) {
            return response()->json(['error' => 'Owner tidak ditemukan'], 404);
        }

        $existingOwner = Owners::where('name', $request->name)->first();
        if ($existingOwner && $existingOwner->id != $request->id) {
            return response()->json(['error' => 'Nama owner sudah ada'], 400);
        }

        $owner->update([
            'name'    => $request->name,
            'address' => $request->address,
            'note'    => $request->note,
        ]);
        

        return response()->json(['success' => 'Owner berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $owner = Owners::find($id);
        if (!$owner) {
            return response()->json(['error' => 'Owner tidak ditemukan'], 404);
        }
        
        $owner->delete();
        return response()->json(['success' => 'Owner berhasil dihapus']);
    }
    
}
