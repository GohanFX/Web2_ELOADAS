<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        // Only for authenticated users
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return Inertia::render('Messages/Index', [
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        return Inertia::render('Contact/Create');
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
}

