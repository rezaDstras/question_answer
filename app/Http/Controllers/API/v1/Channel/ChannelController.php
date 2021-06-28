<?php

namespace App\Http\Controllers\API\v1\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    public function getAllChannels()
    {
        $all_channels= resolve(ChannelRepository::class)->all();
        return response()->json($all_channels,Response::HTTP_OK);
    }

    /**
     * @method POST
     * @param Request $request
     * @return JsonResponse
     */
    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        //Insert Channel To Database
        resolve(ChannelRepository::class)->create($request);

        return response()->json([
           "message" => "channel created successfully"

            //201 = created
        ],Response::HTTP_CREATED);
    }

    /**
     * Update Channel
     * @method PUT
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        //update data
        resolve(ChannelRepository::class)->update($request);

        return response()->json([
           "message" => "edit channel successfully"

            //use response class = 200
        ],Response::HTTP_OK);
    }

    /**
     * Delete Channel(s)
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required'],
        ]);

        //Delete Channel In Database
        resolve(ChannelRepository::class)->destroy($request);

        return response()->json([
            "message" => "channel deleted successfully"
        ],Response::HTTP_OK);

    }




}
