<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::where('customer_id', $request->input('customer_id'))->get();
        return response()->json($contacts);
    }

    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        return response()->json($contact, 201);
    }

    public function show(Contact $contact)
    {
        return response()->json($contact);
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return response()->json($contact);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(null, 204);
    }
}
