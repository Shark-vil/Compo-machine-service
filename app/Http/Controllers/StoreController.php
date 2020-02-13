<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::get();

        return view('stores/index', [ 'stores' => $stores ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stores/create');
    }

    public function view(int $storeid)
    {
        return view('stores/view', ['storeid' => $storeid]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $street = $request->input('street');
        $city = $request->input('city');
        $numprice_on_object = $request->input('numprice_on_object');
        $additional_information = $request->input('additional_information');

        if ( !isset($name) || !isset($street) || !isset($city) || !isset($numprice_on_object) )
        {
            return response()->json([
                'success' => false,
                'content' => 'error',
                'error' => [
                    'type' => 'values_missing',
                    'description' => 'Some values are missing.' 
                ]
            ]);
        }

        if ( empty($name) || empty($street) || empty($city) || intval($numprice_on_object) < 0 )
        {
            return response()->json([
                'success' => false,
                'content' => 'error',
                'error' => [
                    'type' => 'bad_value',
                    'description' => 'The received parameters have invalid values.' 
                ]
            ]);
        }
        
        $data = array(
            'name' => $name,
            'street' => $street,
            'city' => $city,
            'numprice_on_object' => $numprice_on_object,
            'additional_information' => ( !isset($additional_information) ) ? "" : $additional_information
        );

        $StoreId = Store::insertGetId($data);
        $LastData = Store::where('id', $StoreId)->limit(1)->get()->toArray()[0];

        return response()->json([
            'success' => true,
            'content' => $LastData
        ]);
    }

    /**
     * Display the specified resource.
     *----------------------
     * OLD: public function show(Store $store)
     * NEW: public function show(int $storeid)
     * ---------------------
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(int $storeid)
    {
        $store = Store::where('id', $storeid)->limit(1)->get()->toArray();
        if ( count( $store ) == 0 )
            return response()->json([
                'success' => false,
                'content' => 'error',
                'error' => [
                    'type' => 'bad_id',
                    'description' => 'There is no such value in the database.' 
                ]
            ]);

        return response()->json([
            'success' => true,
            'content' => $store[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
