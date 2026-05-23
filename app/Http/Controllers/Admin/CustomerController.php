<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'user')->withCount('orders')->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);
        $orders = $customer->orders()->latest()->paginate(10);
        return view('admin.customers.show', compact('customer', 'orders'));
    }
}
