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
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$stores = Store::all();
        //dd($stores);

        return view('store/add');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            //
        }

        if ( empty($name) || empty($street) || empty($city) || intval($numprice_on_object) < 0 )
        {
            //
        }
        
        $data = array(
            'name' => $name,
            'street' => $street,
            'city' => $city,
            'numprice_on_object' => $numprice_on_object,
            'additional_information' => ( !isset($additional_information) ) ? "" : $additional_information
        );

        Store::insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
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
