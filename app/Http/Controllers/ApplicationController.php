<?php

namespace App\Http\Controllers;

use App\Helpers\Bitrix24;
use App\Helpers\Telegram;
use App\Http\Resources\ApplicationResource;
use App\Jobs\ApplicationMailJob;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => '',
            'phone' => 'required',
            'body' => '',
            'web_site_id' => 'required|exists:web_sites,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $application = Application::create($validator->validated());

        $tg_responses = Telegram::send($application);

        $bitrix24_response = Bitrix24::send($application);

        dispatch(new ApplicationMailJob($application));

        return response()->json([
            'message' => 'success',
            'data' => [
                'application' => new ApplicationResource($application),
                'telegram_message_responses' => $tg_responses,
                'bitrix24_add_lead_responses' => $bitrix24_response,

            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return response()->json([
            'message' => 'success',
            'data' => new ApplicationResource($application),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
