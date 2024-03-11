<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Contact::find(1);
        return response()->json([
            'data'=>$data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
       $data = Contact::find(1);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        Contact::find(1)->update([
            'address' => $data->address,
            'phone_1' => $data->phone_1,
            'phone_2' => $data->phone_2,
            'phone_3' => $data->phone_3,
            'whats_up' => $data->whats_up,
            'email_1' => $data->email_1,
            'email_2' => $data->email_2,
            'contact_telegram' => $data->contact_telegram,
            'contact_skype' => $data->contact_skype,
            'contact_viber' => $data->contact_viber,
            'contact_whats_up' => $data->contact_whats_up,
            'sub_tiktok' => $data->sub_tiktok,
            'sub_youtube' => $data->sub_youtube,
            'sub_vk' => $data->sub_vk,
            'sub_od' => $data->sub_od,
            'sub_x' => $data->sub_x,
            'lang' => $data->lang,
            'long' => $data->long
        ]);
        return response()->json([
            "status" => 200,

        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
