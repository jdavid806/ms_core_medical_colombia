<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $service;
    protected $relations = ['branch'];

    public function __construct(TicketService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service
            ->getAll()
            ->load($this->relations);
    }

    public function indexByReasons(Request $request)
    {
        return $this->service
            ->getTicketsByReasons($request->reasons)
            ->load($this->relations);
    }

    public function show($id)
    {
        return $this->service
            ->getById($id)
            ->load($this->relations);
    }

    public function store(StoreTicketRequest $request)
    {
        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);

        return $this->service->create($request->validated());
    }

    public function update(UpdateTicketRequest $request, $id)
    {
        $xDomain = $request->header('X-DOMAIN');
        app()->instance('X-Domain-Global', $xDomain);

        return $this->service->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
