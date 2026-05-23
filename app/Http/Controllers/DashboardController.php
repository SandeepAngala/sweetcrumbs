<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\BakeryNotification;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ordersCount = Order::where('user_id', $user->id)->count();
        $pendingOrdersCount = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact('user', 'ordersCount', 'pendingOrdersCount', 'wishlistCount', 'recentOrders'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|confirmed|min:8',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.orders', compact('orders'));
    }

    public function orderDetail($orderNumber)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('order_number', $orderNumber)
            ->with(['items.product', 'address', 'payments'])
            ->firstOrFail();

        return view('dashboard.order-detail', compact('order'));
    }

    public function addresses()
    {
        $addresses = Address::where('user_id', auth()->id())->get();
        return view('dashboard.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        $userId = auth()->id();

        if ($request->is_default) {
            Address::where('user_id', $userId)->update(['is_default' => false]);
        }

        Address::create(array_merge($request->all(), [
            'user_id' => $userId,
            'is_default' => $request->has('is_default') ? $request->is_default : false
        ]));

        return back()->with('success', 'Address added successfully!');
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Address::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        $request->validate([
            'label' => 'required|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->is_default) {
            Address::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        $address->update(array_merge($request->all(), [
            'is_default' => $request->has('is_default') ? $request->is_default : false
        ]));

        return back()->with('success', 'Address updated successfully!');
    }

    public function deleteAddress($id)
    {
        Address::where('user_id', auth()->id())->where('id', $id)->delete();
        return back()->with('success', 'Address deleted successfully!');
    }

    public function notifications()
    {
        $notifications = BakeryNotification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('dashboard.notifications', compact('notifications'));
    }

    public function markNotificationRead($id)
    {
        $notification = BakeryNotification::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
