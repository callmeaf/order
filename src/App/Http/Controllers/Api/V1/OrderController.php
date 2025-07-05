<?php

namespace Callmeaf\Order\App\Http\Controllers\Api\V1;

use Callmeaf\Base\App\Http\Controllers\Api\V1\ApiController;
use Callmeaf\Order\App\Repo\Contracts\OrderRepoInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends ApiController implements HasMiddleware
{
    public function __construct(protected OrderRepoInterface $orderRepo)
    {
        parent::__construct($this->orderRepo->config);
    }

    public static function middleware(): array
    {
        return [
           //
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->orderRepo->latest()->search()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        return $this->orderRepo->create(data: $this->request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->orderRepo->findById(value: $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        return $this->orderRepo->update(id: $id, data: $this->request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->orderRepo->delete(id: $id);
    }

    public function statusUpdate(string $id)
    {
        return $this->orderRepo->update(id: $id, data: $this->request->validated());
    }

    public function typeUpdate(string $id)
    {
        return $this->orderRepo->update(id: $id, data: $this->request->validated());
    }

    public function trashed()
    {
        return $this->orderRepo->trashed()->latest()->search()->paginate();
    }

    public function restore(string $id)
    {
        return $this->orderRepo->restore(id: $id);
    }

    public function forceDestroy(string $id)
    {
        return $this->orderRepo->forceDelete(id: $id);
    }
}
