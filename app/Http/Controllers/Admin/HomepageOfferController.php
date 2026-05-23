<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageOffer;
use Illuminate\Http\Request;

class HomepageOfferController extends Controller
{
    public function index()
    {
        $offers = HomepageOffer::orderBy('sort_order')->paginate(20);

        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.offers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        HomepageOffer::create($data);

        return redirect()->route('admin.offers.index')->with('success', 'Homepage offer created.');
    }

    public function edit(HomepageOffer $offer)
    {
        return view('admin.offers.edit', compact('offer'));
    }

    public function update(Request $request, HomepageOffer $offer)
    {
        $offer->update($this->validated($request));

        return redirect()->route('admin.offers.index')->with('success', 'Homepage offer updated.');
    }

    public function destroy(HomepageOffer $offer)
    {
        $offer->delete();

        return back()->with('success', 'Offer deleted.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'icon_classes' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }
}
