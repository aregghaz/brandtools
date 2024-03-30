<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestPriceCollection;
use App\Models\Contact;
use App\Models\RequestPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Contact::find(1);
        return response()->json([
            'data' => $data
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
            'phone_4' => $data->phone_4,
            'whats_up' => $data->whats_up,
            'email_1' => $data->email_1,
            'email_2' => $data->email_2,
            'contact_telegram' => $data->contact_telegram,
            'contact_whats_up' => $data->contact_whats_up,
            'sub_tiktok' => $data->sub_tiktok,
            'sub_youtube' => $data->sub_youtube,
            'sub_x' => $data->sub_x,
            'lang' => $data->lang,
            'long' => $data->long
        ]);
        return response()->json([
            "status" => 200,

        ]);

    }

    public function getSingleRequestPrice($id)
    {
        $data = RequestPrice::find($id);
        return response()->json($data);


    }

    public function requestPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'lastName' => 'required|string',
            'company' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'ihh' => 'required|string',
            'kpp' => 'required|string',
            'bik' => 'required|string',
            'pc' => 'required|string',
            'address' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json(['success' => 0, 'type' => 'validation_filed', 'error' => $validator->messages()], 422);
        }
        RequestPrice::create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'phone' => $request->phone,
            'email' => $request->email,
            'company' => $request->company,
            'ihh' => $request->ihh,
            'kpp' => $request->kpp,
            'bik' => $request->bik,
            'pc' => $request->pc,
            'address' => $request->address,
            'notes' => $request->notes ?? null
        ]);

        $content = [
            'subject' => 'This is the mail subject',
            'body' => 'This is the email body of how to send email from laravel 10 with mailtrap.'
        ];

        Mail::to('your_email@gmail.com')->send(new SampleMail($content));


        return response()->json([
            "status" => 200,
        ]);
    }


    public function getAllRequest()
    {
        $data = RequestPrice::all();
        return response()->json(new RequestPriceCollection($data));
    }


    public function priceGroupDelete(Request $request)
    {
        $products = RequestPrice::whereIn('id', $request->ids)->get();
        foreach ($products as $product) {
            $product->delete();
        }
        return response()->json([
            'status' => 200,
        ]);
    }

    public function deleteRequestPrice($id)
    {
        RequestPrice::find($id)->delete();
        return response()->json([
            'status' => 200,
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
