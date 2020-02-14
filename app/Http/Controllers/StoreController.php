<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Routing\UrlGenerator;

class StoreController extends Controller
{
    protected $url;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;

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
    public function create(Request $request)
    {
        if (count($request->all()) != 0)
        {
            $toArray = json_decode( $this->store($request)->content(), FALSE );

            if ( !$toArray->success )
                return view('stores/create', ['data' => $toArray]);
            else
                return redirect("stores/view/{$toArray->content->id}");
        }

        return view('stores/create');
    }

    public function view(int $storeid)
    {
        $toArray = json_decode( $this->show($storeid)->content(), FALSE );

        if ( !$toArray->success )
            return redirect('stores');

        return view('stores/view', ['data' => $toArray]);
    }

    public function remove(int $storeid)
    {
        $toArray = json_decode( $this->destroy($storeid)->content(), FALSE );
        return redirect('stores');
    }

    public function change(Request $request, int $storeid)
    {
        if (count($request->all()) != 0)
        {
            $toArray = json_decode( $this->update($request, $storeid)->content(), FALSE );

            if ( !$toArray->success )
                return view("stores/change", ['data' => $toArray]);
            else
                return redirect("stores/change/{$toArray->content->id}");
        }

        $toArray = json_decode( $this->show($storeid)->content(), FALSE );

        if ( !$toArray->success )
            return redirect('stores');

        return view('stores/change', ['data' => $toArray]);
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
     *----------------------
     * OLD: public function update(Request $request, Store $store)
     * NEW: public function update(Request $request, int $storeid)
     * ---------------------
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $storeid)
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

        $name = $request->input('name');
        $street = $request->input('street');
        $city = $request->input('city');
        $numprice_on_object = $request->input('numprice_on_object');
        $additional_information = $request->input('additional_information');

        $newData = array(
            'id' => $storeid,
            'name' => $name,
            'street' => $street,
            'city' => $city,
            'numprice_on_object' => $numprice_on_object,
            'additional_information' => ( !isset($additional_information) ) ? "" : $additional_information
        );

        $result = Store::where('id', $storeid)->update($newData);

        return response()->json([
            'success' => true,
            'content' => $newData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *----------------------
     * OLD: public function destroy(Store $store)
     * NEW: public function destroy(int $storeid)
     * ---------------------
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $storeid)
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

        $result = Store::destroy($store[0]['id']);

        return response()->json([
            'success' => true,
            'content' => $store[0]
        ]);
    }
}
