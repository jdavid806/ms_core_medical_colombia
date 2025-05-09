<?php

namespace App\Services;

use App\Models\Contact;
use App\Repositories\ContactRepository;

class ContactService
{
    public function __construct(private ContactRepository $contactRepository) {}

    public function getAllContacts()
    {
        return $this->contactRepository->all();
    }

    public function getContactById(Contact $contact)
    {
        return $this->contactRepository->find($contact);
    }

    public function createContact(array $data)
    {
        return $this->contactRepository->create($data);
    }

    public function updateContact(Contact $contact, array $data)
    {
        return $this->contactRepository->update($contact, $data);
    }

    public function deleteContact(Contact $contact)
    {
        return $this->contactRepository->delete($contact);
    }
}
