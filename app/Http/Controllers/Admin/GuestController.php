<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    /**
     * List all guests
     */
    public function index()
    {
        $guests = Guest::orderBy('created_at', 'desc')->get();
        return view('admin.guests.index', compact('guests'));
    }

    /**
     * Store a new guest
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'id_card_number' => 'nullable|string',
            'id_card_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('id_card_image')) {
            $validated['id_card_image'] = $request->file('id_card_image')->store('id_cards', 'public');
        }

        Guest::create($validated);

        return redirect()->route('admin.guests.index')
            ->with('success', 'ភ្ញៀវត្រូវបានបន្ថែមដោយជោគជ័យ!');
    }

    /**
     * Update guest information
     */
    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'id_card_number' => 'nullable|string',
            'id_card_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('id_card_image')) {
            // Delete old image if exists
            if ($guest->id_card_image && Storage::disk('public')->exists($guest->id_card_image)) {
                Storage::disk('public')->delete($guest->id_card_image);
            }

            $validated['id_card_image'] = $request->file('id_card_image')->store('id_cards', 'public');
        }

        $guest->update($validated);

        return redirect()->route('admin.guests.index')
            ->with('success', 'ព័ត៌មានភ្ញៀវត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    /**
     * Delete a guest
     */
    public function destroy(Guest $guest)
    {
        if ($guest->bookings()->exists()) {
            return redirect()->route('admin.guests.index')
                ->with('error', 'មិនអាចលុបភ្ញៀវដែលមានការកក់បានទេ!');
        }

        // Delete ID card image if exists
        if ($guest->id_card_image && Storage::disk('public')->exists($guest->id_card_image)) {
            Storage::disk('public')->delete($guest->id_card_image);
        }

        $guest->delete();

        return redirect()->route('admin.guests.index')
            ->with('success', 'ភ្ញៀវត្រូវបានលុបដោយជោគជ័យ!');
    }
}
