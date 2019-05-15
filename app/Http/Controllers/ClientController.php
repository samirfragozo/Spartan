<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientController extends BaseController
{
    /**
     * Create a controller instance.
     *
     * @param Client $entity
     */
    public function __construct(Client $entity)
    {
        parent::__construct($entity);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return Response
     */
    public function store(ClientRequest $request)
    {
        return parent::storeBase($request, false);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ClientRequest $request, int $id)
    {
        return parent::updateBase($request, $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function status(Request $request)
    {
        $client = $this->entity::find($request->input('id'));

        if ( is_null($client) ) return abort(404);

        $client->active = !$request->input('state');
        $client->save();

        $active = $client->active ? 1 : 0;

        return response()->json([
            'message' => __("base.messages.active.{$active}", ['name' => $client->full_name]),
        ]);
    }
}
