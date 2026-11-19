<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\View\View;

class ContactAdminController extends Controller
{
    public function index(): View
    {
        $contacts = Contact::latest()->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    public function show(Contact $contact): View
    {
        // Menandai pesan sebagai sudah dibaca saat dibuka
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('contacts.show', compact('contact'));
    }
}
