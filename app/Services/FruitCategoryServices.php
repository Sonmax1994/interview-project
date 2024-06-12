<?php

namespace App\Services;

use App\Models\FruitCategory;

class FruitCategoryServices
{
    /**
     * @param int $comicId
     * @return mixed
     */
    public function getListFruitCategory(array $params = [])
    {
        return FruitCategory::paginate(20);
    }

    public function createOrUpdateFruitCategory(array $inputs = [], string $idFruitCategory = '')
    {
        if (!empty($idFruitCategory)) {
            $fruitCategory = FruitCategory::find($idFruitCategory);
        } else {
            $fruitCategory = new FruitCategory();
        }

        $fruitCategory->fill([
            'name' => $inputs['name'],
            'descriptions' => $inputs['descriptions'] ?? null,
        ]);
        $fruitCategory->save();

        return $fruitCategory;
    }

    public function getDetail(string $idFruitCategory = '')
    {
        return FruitCategory::findOrFail($idFruitCategory);
    }

    public function optionListCategoryFruit()
    {
        return FruitCategory::pluck('name', 'id')->toArray();
    }

}
