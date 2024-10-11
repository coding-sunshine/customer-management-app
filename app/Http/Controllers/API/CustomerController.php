<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Arr;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['category', 'contacts']);

        if ($request->has('search')) {

            $category = $request->get('search')['category']??'';

            if($category!=='' && $category!==null){
                $query->where('category_id', $category);
            }

            $searchText = $request->get('search')['search']??'';

            if($searchText!==''){
                $query->where('name', 'like', "%{$searchText}%");
            }
        }

        $customers = $query->paginate(5);

        return response()->json($customers);
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        $contacts = $request->input('contacts')??null;

        if(isset($contacts) && is_array($contacts)){
            foreach( $contacts as $contact ){
                Contact::create([
                    'customer_id' => $customer->id,
                    'first_name' => $contact['first_name'],
                    'last_name' => $contact['last_name'],
                ]);
            }
        }

        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer->load(['category', 'contacts']));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        $contacts = $request->input('contacts')??null;
        $contactIds = Arr::pluck( $contacts, 'id');

        if( !empty( $contactIds ) ){
            Contact::where('customer_id', $customer->id)
                ->whereNotIn('id', $contactIds )
                ->delete();
        }else{
            Contact::where('customer_id', $customer->id)
                ->delete();
        }

        if(isset($contacts) && is_array($contacts)){
            foreach( $contacts as $contact ){
                $got_contact = Contact::find( data_get( $contact, 'id') );
                if( is_null( $got_contact ) ){
                    $got_contact = new Contact();
                    $got_contact->customer_id = $customer->id;
                }
                $got_contact->first_name = data_get( $contact, 'first_name');
                $got_contact->last_name = data_get( $contact, 'last_name');
                $got_contact->save();
            }
        }
        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
