<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FruitItemServices;
use App\Services\FruitCategoryServices;
use App\Http\Requests\FruitItem\CreateFruitItemRequest;
use App\Http\Requests\FruitItem\UpdateFruitItemRequest;
use Illuminate\Support\Facades\DB;
use App\Enums\ItemUnit;

class FruitItemController extends Controller
{
    public function __construct()
    {
        $this->fruitItemServices = new FruitItemServices;
        $this->fruitCategoryServices = new FruitCategoryServices;
    }

    public function index()
    {
        $data = $this->fruitItemServices->getListFruitItem();

        return view('admin.fruit_item.index', [
            'listFruitItem' => $data
        ]);
    }

    public function create()
    {
    	$optionUnitItem = $this->fruitItemServices->getOptionUnitItem();
    	$optionListCategoryFruit = $this->fruitCategoryServices->optionListCategoryFruit();

        return view('admin.fruit_item.create', [
        	'optionUnitItem' => $optionUnitItem,
        	'optionListCategoryFruit' => $optionListCategoryFruit
        ]);
    }

    public function store(CreateFruitItemRequest $request)
    {
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            $fruitItem = $this->fruitItemServices->createOrUpdateFruitItem($inputs);
            DB::commit();

            return redirect()->route('fruit_item.show', ['id' => $fruitItem->getKey()]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $idFruitItem = $request->id;
        $data = $this->fruitItemServices->getDetail($idFruitItem);

        $optionUnitItem = $this->fruitItemServices->getOptionUnitItem();
    	$optionListCategoryFruit = $this->fruitCategoryServices->optionListCategoryFruit();

        return view('admin.fruit_item.edit', [
			'fruitItem'               => $data,
			'optionUnitItem'          => $optionUnitItem,
			'optionListCategoryFruit' => $optionListCategoryFruit
        ]);
    }

    public function edit(UpdateFruitItemRequest $request)
    {
        $idFruitItem = $request->id;
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            $fruitItem = $this->fruitItemServices->createOrUpdateFruitItem($inputs, $idFruitItem);
            DB::commit();

            return redirect()->route('fruit_item.show', ['id' => $fruitItem->getKey()]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Request $request)
    {
        $idFruitCate = $request->id;
        DB::beginTransaction();
        try {
            $data = $this->fruitItemServices->getDetail($idFruitCate);
            $data->delete();
            DB::commit();

            return redirect()->route('fruit_item');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getItemsByCategoryId(Request $request)
    {
    	$categoryId = $request->category_id;
    	if (empty($categoryId)) {
    		return response()->json();
    	}
		$dataItems = $this->fruitItemServices->getItemsByCategoryId($categoryId);
        
        return response()->json($dataItems);
    }

    public function getDetailFruitItem(Request $request)
    {
    	$fruitItemId = $request->itemId;
    	if (empty($fruitItemId)) {
    		return response()->json();
    	}
		$dataItem = $this->fruitItemServices->getDetail($fruitItemId);
        if (!empty($dataItem)) {
        	$dataItem->unit_label = $dataItem->unit->getLabel();
        }

        return response()->json($dataItem);
    }

}
