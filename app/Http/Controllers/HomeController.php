<?php

namespace App\Http\Controllers;

use App\Store;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\StoreController;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stores = Store::get();
        $tickets = Ticket::get();
        $tickets_open = array();
        $tickets_ids = array();

        foreach($tickets as $ticket)
            foreach($stores as $store)
            {
                if ($ticket->store_id == $store->id && $ticket->status)
                {
                    array_push($tickets_open, $store->id);
                    array_push($tickets_ids, $ticket->id);
                }
            }

        return view('home', ['stores' => $stores, 'tickets_open' => $tickets_open, 'tickets_ids' => $tickets_ids]);
    }
}
