<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Only for authenticated users
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return view('messages.index', [
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Contact::create($validated);

        return redirect()->route('contact.create')->with('success', 'Üzenet sikeresen elküldve!');
    }

    // Admin: show edit form for a contact
    public function edit(Contact $contact)
    {
        return view('messages.edit', [
            'contact' => $contact
        ]);
    }

    // Admin: update a contact
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contact->update($validated);

        return redirect()->route('messages.index')->with('success', 'Üzenet sikeresen frissítve!');
    }

    // Admin: delete a contact
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('messages.index')->with('success', 'Üzenet sikeresen törölve!');
    }
}

