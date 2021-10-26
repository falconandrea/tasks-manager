<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all()->sortBy('name');
        return CustomerResource::collection($customers);
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function store(CustomerStoreRequest $request)
    {
        $this->authorize('create', [Customer::class]);

        $data = $request->validated();

        $customer = new Customer();
        $customer->create($data);
    }
}
