<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FruitCategoryServices;
use App\Http\Requests\FruitCategory\CreateFruitCategoryRequest;
use App\Http\Requests\FruitCategory\UpdateFruitCategoryRequest;
use Illuminate\Support\Facades\DB;

class FruitCategoryController extends Controller
{
    public function __construct()
    {
        $this->fruitCategoryServices = new FruitCategoryServices;
    }

    public function index(Request $request)
    {
        $data = $this->fruitCategoryServices->getListFruitCategory();

        return view('admin.fruit_category.index', [
            'listFruitCategory' => $data
        ]);
    }

    public function create()
    {
        return view('admin.fruit_category.create');
    }

    public function store(CreateFruitCategoryRequest $request)
    {
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            $fruitCategory = $this->fruitCategoryServices->createOrUpdateFruitCategory($inputs);
            DB::commit();

            return redirect()->route('fruit_category.show', ['id' => $fruitCategory->getKey()]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $idFruitCate = $request->id;
        $data = $this->fruitCategoryServices->getDetail($idFruitCate);

        return view('admin.fruit_category.edit', [
            'fruitCategory' => $data
        ]);
    }

    public function edit(UpdateFruitCategoryRequest $request)
    {
        $idFruitCate = $request->id;
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            $fruitCategory = $this->fruitCategoryServices->createOrUpdateFruitCategory($inputs, $idFruitCate);
            DB::commit();

            return redirect()->route('fruit_category.show', ['id' => $fruitCategory->getKey()]);

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
            $data = $this->fruitCategoryServices->getDetail($idFruitCate);
            $data->delete();
            DB::commit();

            return redirect()->route('fruit_category');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
