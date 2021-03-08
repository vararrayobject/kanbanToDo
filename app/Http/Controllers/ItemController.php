<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Status;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::get();
        $statuses = Status::get();
        $items = Item::with(['color', 'status'])->orderBy('order')->get();
        return view('dashboard', compact(['statuses', 'colors', 'items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $color = Color::find(1);
        $latestItem = Item::whereStatusId($request->status_id)->latest()->first();
        $item = new Item();
        $item->status_id = $request->status_id;
        $item->color_id = $color->id;
        $item->desc = $request->desc;
        $item->order = $latestItem === null ? 0 : $latestItem->order + 1;
        $item->save();
        return ($item->with(['color', 'status'])->latest()->first()->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = tap(Item::with(['color', 'status'])->find($id))->update(
            [
                'color_id' => $request->color_id,
                'desc' => $request->desc,
            ]
        );
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update the status and order when task is dragged.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $task = Item::find($request->task_id)->update(['status_id' => $request->status_id]);
        foreach ($request->list as $key => $value) {
            Item::find($value)->update(['order' => $key]);
        }
        return response(['status' => true]);
    }
}
