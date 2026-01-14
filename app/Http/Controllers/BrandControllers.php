<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brands;



class BrandControllers extends Controller
{
    
    public function index()
    {
        return view('page.brands.index');
    }
    //getDatatable
    public function getDatatable(Request $request)
    {
        $brands = Brands::get();
        // dd($brands);
        return datatables()->of($brands)
            ->addColumn('action', function ($brand) {
                  return '<button class="btn btn-sm btn-primary edit-btn" onclick="editBrand('.$brand->id.')" data-id="'.$brand->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" onclick="deleteBrand('.$brand->id.')" data-id="'.$brand->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
        
    }

   
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
       
        $existingBrand = Brands::where('brand_name', $request->brand_name)->first();
        if ($existingBrand) {
            return redirect()->back()->with('error', 'Nama brand sudah ada');
        }

        $brand = new Brands();
        $brand->brand_name = $request->brand_name;
        $brand->save();
        return redirect()->back()->with('success', 'Brand berhasil ditambahkan');
    }

  
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $brand = Brands::find($id);
        return response()->json($brand);
    }


    public function update(Request $request)
    {
        $brand = Brands::find($request->id);
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand tidak ditemukan');
        }
        
        $existingBrand = Brands::where('brand_name', $request->brand_name)->first();
        if ($existingBrand && $existingBrand->id != $brand->id) {
            return redirect()->back()->with('error', 'Nama brand sudah ada');
        }
        
        $brand->update([
            'brand_name' => $request->brand_name,
        ]);
        return response()->json(['success' => 'Brand berhasil diupdate']);
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        $brand = Brands::find($id);
        if (!$brand) {
            return response()->json(['error' => 'Brand tidak ditemukan'], 404);
        }
        
        $brand->delete();
        return response()->json(['success' => 'Brand berhasil dihapus']);
    }
}
