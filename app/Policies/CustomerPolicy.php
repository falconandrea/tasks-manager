<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->can('add customer') ? true : false;
    }

    public function update(User $user, $customerId)
    {
        Customer::where('id', $customerId)->firstOrfail();
        return $user->can('add customer') ? true : false;
    }
}
