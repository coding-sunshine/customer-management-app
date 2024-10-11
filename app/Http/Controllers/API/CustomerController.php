<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['category', 'contacts']);

        if( !empty( $data ) && is_array( $data ) ){
            $category = data_get( $data, 'category');
            $searchText = data_get( $data, 'search_text');

            if( !empty( $category ) ){
                $q->searchCategoryId( $category );
            }

            if( !empty( $searchText ) ){
                $q->commonSearchText( $searchText );
            }
        }

        if ($request->has('search')) {

            $category = $request->get('search')['category']??'';
            $searchText = $request->get('search')['search']??'';

            if($searchText!==''){
                $query->where('name', 'like', "%{$searchText}%")
                    ->orWhere('reference', 'like', "%{$searchText}%");
            }

            if($category!=='' && $category!==null){
                $query->where('category_id', $category);
            }
        }

        $customers = $query->paginate(5);

        return response()->json($customers);
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        return response()->json($customer->load(['category', 'contacts']));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return response()->json($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
