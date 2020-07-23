<?php

namespace App\Http\Controllers;

use Auth;
use App\message;
use App\User;
use App\Ticket;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function remove(int $ticket_id)
    {
        $this->destroy($ticket_id);
        return redirect('tickets');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = $request->input('message');
        $ticket_id = $request->input('ticket_id');

        if ( !isset($message) || !isset($ticket_id))
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

        if ( empty($message) || empty($ticket_id) || intval($ticket_id) < 0 )
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

        $ticket = Ticket::where('id', $ticket_id)->limit(1)->get()->toArray();

        if ( count( $ticket ) == 0 )
            return response()->json([
                'success' => false,
                'content' => 'error',
                'error' => [
                    'type' => 'bad_ticket',
                    'description' => 'There is no such ticket.' 
                ]
            ]);

        $ticket = (object) $ticket[0];

        if ( !$ticket->status )
            return response()->json([
                'success' => false,
                'content' => 'error',
                'error' => [
                    'type' => 'bad_status',
                    'description' => 'The ticket is already closed.' 
                ]
            ]);
        
        $data = array(
            'message' => $message,
            'ticket_id' => $ticket_id,
            'user_name' => Auth::user()->name,
            'date_time' => date("Y-m-d H:i:s"),
            'user_id' => Auth::id()
        );

        $StoreId = Message::insertGetId($data);
        $LastData = Message::where('id', $StoreId)->limit(1)->get()->toArray()[0];

        return response()->json([
            'success' => true,
            'content' => $LastData
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(int $ticket_id)
    {
        $ticket = Ticket::where('id', $ticket_id)->limit(1)->get()->toArray();

        if ( count( $ticket ) == 0 )
            return response()->json([
                'success' => false,
                'content' => 'error',
                'error' => [
                    'type' => 'bad_ticket',
                    'description' => 'There is no such ticket.' 
                ]
            ]);

        $messages = Message::where('ticket_id', $ticket_id)->get()->toArray();

        return response()->json([
            'success' => true,
            'content' => [
                'ticket_status' => $ticket[0]['status'],
                'messages' => $messages
            ]
        ]);
    }
}
