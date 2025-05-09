<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Contact $contact)
    {
        parent::__construct($contact, self::RELATIONS);
    }
}
