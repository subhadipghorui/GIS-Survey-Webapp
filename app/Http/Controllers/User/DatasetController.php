<?php

namespace App\Http\Controllers\User;

use App\Dataset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class DatasetController extends Controller
{
    public function index(){
        $datasets = Dataset::all();
        return view('user.dataset.index', compact('datasets'));
    }
    public function ajaxData(){
        $model = Dataset::query();
        return DataTables::of($model)->toJson();
    }

    public function create(){
        return view('user.dataset.create');
    }
    public function store(Request $request){
        $this->validate($request, [
            'first_name' => 'required|max:255',
        ]);

        // Add Php Cache later
        $dataset = Dataset::create($request->all());
        return response(["data" => $dataset], 200);
    }

    public function update(Request $request){
        $this->validate($request, [
            'first_name' => 'required|max:255',
        ]);
        $dataset = Dataset::findOrFail($request->id);
        // Add Php Cache later
        $dataset->first_name = $request->first_name;
        $dataset->last_name = $request->last_name;
        $dataset->age = $request->age;
        $dataset->dob = $request->dob;
        $dataset->lat = $request->lat;
        $dataset->lng = $request->lng;
        $dataset->save();

        return response(["data" => $dataset], 200);
    }

    public function destroy(Request $request){
        $dataset = Dataset::findOrFail($request->id);
        $dataset->delete();
        return response(["Dataset Deleted"], 200);
    }
}
