<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Http\Resources\Item as ItemResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get items
        $items = Item::paginate(15);

        // Return collection of items as a resource
        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** 
         * Method = put  -> get item
         * Method = post -> create new item
         * */
        $item = $request->isMethod('patch') ? 
            Item::findOrFail($request->id) : new Item;
        
        $item->id = $request->input('id');
        $item->name = $request->input('name');
        $item->type = $request->input('type');
        $item->description = $request->input('description');
        $item->photo_url = $request->input('photo_url');
        $item->price = $request->input('price');
        
        if($item->save())
        {
            return new ItemResource($item);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get item
        $item = Item::findOrFail($id);

        // Return item as a resource
        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get item
        $item = Item::findOrFail($id);

        // Method = delete -> return deleted item 
        if ($item->delete()) {
            return new ItemResource($item);
        }
    }
}
