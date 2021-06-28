<?php
namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelRepository
{
    /**
     * Show All Channel
     *
     */
    public function all()
    {
       return Channel::all();
    }
    /**
     * Create Channel
     * @param Request $request
     */
    public function create(Request $request)
    {
        Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    }

    /**
     * Update Channel
     * @param Request $request
     */
    public function update(Request $request)
    {
        Channel::find($request->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        Channel::destroy($request->id);
    }
}
