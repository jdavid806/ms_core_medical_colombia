<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\ContactService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Contact\ContactResource;
use App\Http\Requests\Api\V1\Contact\StoreContactRequest;
use App\Http\Requests\Api\V1\Contact\UpdateContactRequest;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService) {}

    public function index()
    {
        $contacts = $this->contactService->getAllContacts();
        return ContactResource::collection($contacts);
    }

    public function store(StoreContactRequest $request)
    {
        $contact = $this->contactService->createContact($request->validated());
        return response()->json([
            'message' => 'Contact created successfully',
            'Contact' => $contact,
        ]);
    }

    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $this->contactService->updateContact($contact, $request->validated());
        return response()->json([
            'message' => 'Contact updated successfully',
        ]);
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        return response()->json([
            'message' => 'Contact deleted successfully',
        ]);
    }

    //
}
