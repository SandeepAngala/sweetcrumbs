<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::whereIn('role', ['user', 'customer'])
            ->with('orders')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::whereIn('role', ['user', 'customer'])->findOrFail($id);
        $orders = $customer->orders()->latest()->paginate(10);

        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function block($id)
    {
        $customer = User::whereIn('role', ['user', 'customer'])->findOrFail($id);
        $customer->update(['is_blocked' => true, 'blocked_at' => now()]);

        return back()->with('success', 'Customer blocked successfully.');
    }

    public function unblock($id)
    {
        $customer = User::whereIn('role', ['user', 'customer'])->findOrFail($id);
        $customer->update(['is_blocked' => false, 'blocked_at' => null]);

        return back()->with('success', 'Customer unblocked successfully.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'sweet-crumbs-customers-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Orders', 'Loyalty Points', 'Joined']);

            User::whereIn('role', ['user', 'customer'])
                ->with('orders')
                ->chunk(100, function ($customers) use ($handle) {
                    foreach ($customers as $customer) {
                        fputcsv($handle, [
                            $customer->id,
                            $customer->name,
                            $customer->email,
                            $customer->phone,
                            $customer->orders_count,
                            $customer->loyalty_points,
                            $customer->created_at->format('Y-m-d'),
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
