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

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('reference', 'like', "%{$search}%");
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $customers = $query->paginate(10);

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
