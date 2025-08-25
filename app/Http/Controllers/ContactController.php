<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Afficher le formulaire de contact
     */
    public function show(): View
    {
        return view('contact.show');
    }

    /**
     * Traiter l'envoi du formulaire de contact
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return redirect()
            ->route('contact.show')
            ->with('success', 'Uw bericht is succesvol verzonden! We nemen zo snel mogelijk contact met u op.');
    }

    /**
     * Dashboard admin : afficher les messages de contact
     * (Accessible seulement aux admins)
     */
    public function index(): View
    {
        $this->middleware('is_admin');
        
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        $unreadCount = Contact::unread()->count();

        return view('contact.index', compact('contacts', 'unreadCount'));
    }

    /**
     * Marquer un message comme lu
     */
    public function markAsRead(Contact $contact): RedirectResponse
    {
        $this->middleware('is_admin');
        
        $contact->update(['is_read' => true]);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Bericht gemarkeerd als gelezen.');
    }

    /**
     * Supprimer un message
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $this->middleware('is_admin');
        
        $contact->delete();

        return redirect()
            ->route('contact.index')
            ->with('success', 'Bericht succesvol verwijderd.');
    }

    /**
     * Afficher les détails d'un message
     */
    public function showMessage(Contact $contact): View
    {
        $this->middleware('is_admin');
        
        // Marquer automatiquement comme lu lors de la consultation
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('contact.message', compact('contact'));
    }
}