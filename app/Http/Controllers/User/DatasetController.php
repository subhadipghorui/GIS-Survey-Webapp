<?php

namespace App\Http\Controllers\User;

use App\Dataset;
use App\Http\Controllers\Controller;
use App\PostGISDataset;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use MStaack\LaravelPostgis\Geometries\Point;

class DatasetController extends Controller
{
    public function index(){
        $datasets = Dataset::all();
        return view('user.dataset.index');
    }
    public function ajaxData(){
        $model = PostGISDataset::query();
        return DataTables::of($model)->toJson();
    }
    public function geoJson(){
        /***
         * Read SQL Injection attacks
         * https://www.stackhawk.com/blog/sql-injection-prevention-laravel/
         *
         * DB::connection('pgsql')->select('select *,ST_AsGeoJSON(geom) as geom from gis_data_entry_table where id=?', [7]);
         *
         */
        // $dataset = PostGISDataset::first();
        // return $dataset->only('id', 'first_name');

        $datasets = PostGISDataset::all();
        $datasetToGeoJsonFeatures = [];
        foreach($datasets as $dataset){
            $obj = [];
            $obj['type'] = 'Feature';
            $obj['geometry'] = $dataset->geom;
            $obj['properties'] = $dataset->only('id', 'first_name', 'last_name', 'age', 'dob');
            array_push($datasetToGeoJsonFeatures,$obj);
        }

        $datasetToGeoJson = [
            "type" => "FeatureCollection",
            "features" => $datasetToGeoJsonFeatures
        ];
        return $datasetToGeoJson;
    }

    public function create(){
        return view('user.dataset.create');
    }
    public function store(Request $request){
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|max:255',
            'dob' => 'required|date|max:255',
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
        ]);

        // Add Php Cache later
        $dataset = new PostGISDataset();
        $dataset->first_name = $request->first_name;
        $dataset->last_name = $request->last_name;
        $dataset->age = $request->age;
        $dataset->dob = $request->dob;
        $dataset->geom = new Point($request->lat, $request->lng);
        $dataset->save();

        return response(["data" => $dataset->toJson()], 200);
    }

    public function update(Request $request){
        $this->validate($request, [
            'id' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|max:255',
            'dob' => 'required|date|max:255',
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
        ]);
        $dataset = PostGISDataset::findOrFail($request->id);
        // Add Php Cache later
        $dataset->first_name = $request->first_name;
        $dataset->last_name = $request->last_name;
        $dataset->age = $request->age;
        $dataset->dob = $request->dob;
        $dataset->geom = new Point($request->lat, $request->lng);
        $dataset->save();

        return response(["data" => $dataset->toJson()], 200);
    }

    public function destroy(Request $request){
        $dataset = PostGISDataset::findOrFail($request->id);
        $dataset->delete();
        return response(["Dataset Deleted"], 200);
    }
}
