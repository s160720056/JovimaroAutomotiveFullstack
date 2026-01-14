<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use App\Models\Owners;
use App\Models\Brands;



class CarControllers extends Controller
{

    public function index()
    {
        $cars = Cars::with(['owner', 'brand'])->get();
        $owners = Owners::all();
        $brands = Brands::all();
        return view('page.cars.index', compact('cars', 'owners', 'brands'));    
    }
    //getDatatable
public function getDatatable(Request $request)
{
    $query = Cars::with(['owner', 'brand']);

    if ($request->filled('owner')) {
        $query->whereHas('owner', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->owner . '%');
        });
    }

    if ($request->filled('brand')) {
        $query->whereHas('brand', function ($q) use ($request) {
            $q->where('brand_name', 'like', '%' . $request->brand . '%');
        });
    }

    return datatables()->of($query)
        ->addColumn('action', function ($car) {
            return '
                <button class="btn btn-sm btn-primary" onclick="editCar('.$car->id.')">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteCar('.$car->id.')">Delete</button>
            ';
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
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'brand_id' => 'required|exists:brands,id',
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
            
            
        ]);
        $owner = Owners::where('id', $request->owner_id)->first();
        $brand = Brands::where('id', $request->brand_id)->first();
        $car = new Cars();
        $car->owner_id = $owner->id;
        $car->brand_id = $brand->id;
        $car->color = $request->color;
        $car->description = $request->description;
        $car->save();
        return redirect()->back()->with('success', 'Mobil berhasil ditambahkan');
    }

   
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $car = Cars::with(['owner', 'brand'])->where('id', $id)->first();
        return response()->json($car);
    }


    public function update(Request $request)
    {
              
        $id = $request->id;
        $request->validate([
            'id' => 'required|exists:cars,id',
            'owner_id' => 'required|exists:owners,id',
            'brand_id' => 'required|exists:brands,id',
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $owner = Owners::where('id', $request->owner_id)->first();
        $brand = Brands::where('id', $request->brand_id)->first();
        $car = Cars::where('id', $id)->first();
        $car->owner_id = $owner->id;
        $car->brand_id = $brand->id;
        $car->color = $request->color;
        $car->description = $request->description;
        $car->save();
        return response()->json(['success' => 'Mobil berhasil diupdate']);
    }


    public function destroy(Request $request)
    {
        
        $id = $request->id;
        $car = Cars::where('id', $id)->first();
        $car->delete();
        return response()->json(['success' => 'Mobil berhasil dihapus']);
    }
}
