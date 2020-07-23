<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Store;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $ticket_id)
    {
        $ticket = (object) Ticket::where('id', $ticket_id)->limit(1)->get()->toArray()[0];
        return view('tickets/index', ['ticket' => $ticket, 'status' => $ticket->status]);
    }

    public function view()
    {
        $tickets = Ticket::get()->toArray();

        for($i = 0; $i < count( $tickets ); $i++ )
        {
            $store = Store::where('id', $tickets[$i]['store_id'])->limit(1)->get()->toArray()[0];
            $tickets[$i]['name'] = $store['name'];
            $tickets[$i]['street'] = $store['street'];
            $tickets[$i]['city'] = $store['city'];
            $tickets[$i]['numprice_on_object'] = $store['numprice_on_object'];
        }
        
        return view('tickets/view', ['tickets' => $tickets]);
    }

    public function open(int $storeid)
    {
        $this->store($storeid);
        return redirect('home');
    }

    public function close(int $ticket_id)
    {
        $ticket = Ticket::where('id', $ticket_id)->limit(1)->get()->toArray();
        if ( count( $ticket ) != 0 )
        {
            $ticket[0]['status'] = false;
            Ticket::where('id', $ticket_id)->update($ticket[0]);

            return response()->json([
                'success' => true,
                'content' => $ticket[0]
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $storeid)
    {
        $date = date("Y-m-d H:i:s");

        if ( !isset($storeid) )
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

        if ( intval($storeid) < 0 )
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
            'status' => true,
            'date' => $date,
            'store_id' => $storeid
        );

        $StoreId = Ticket::insertGetId($data);
        $LastData = Ticket::where('id', $StoreId)->limit(1)->get()->toArray()[0];

        return response()->json([
            'success' => true,
            'content' => $LastData
        ]);
    }
}
