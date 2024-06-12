<?php

namespace App\Services;

use App\Models\FruitItem;
use App\Enums\ItemUnit;

class FruitItemServices
{
    /**
     * @param int $comicId
     * @return mixed
     */
    public function getListFruitItem(array $params = [])
    {
        $datas = FruitItem::with('fruitCategory')->paginate(20);
        return $datas;
    }

    public function createOrUpdateFruitItem(array $inputs = [], string $idFruitItem = '')
    {
        if (!empty($idFruitItem)) {
            $fruitItem = FruitItem::find($idFruitItem);
        } else {
            $fruitItem = new FruitItem();
        }

        $fruitItem->fill([
            'name'        => $inputs['name'],
            'category_id' => $inputs['category_id'],
            'unit'        => $inputs['unit'],
            'price'       => $inputs['price'],
        ]);
        $fruitItem->save();

        return $fruitItem;
    }

    public function getDetail(string $idFruitItem = '')
    {
        return FruitItem::findOrFail($idFruitItem);
    }

    public function getArrValueUnitItem()
    {
        $arrValueUnitItem = [];
        $unitItems = ItemUnit::cases();
        foreach ($unitItems as $unitItem) {
            array_push($arrValueUnitItem, $unitItem->value);
        }
        
        return $arrValueUnitItem;
    }

    public function getOptionUnitItem()
    {
        $optionUnitItem = [];
        $unitItems = ItemUnit::cases();
        foreach ($unitItems as $unitItem) {
            $optionUnitItem[$unitItem->value] = $unitItem->getLabel();
        }
        
        return $optionUnitItem;
    }

    public function getItemsByCategoryId($idCategory)
    {
        $datas = FruitItem::where('category_id', $idCategory)
            ->pluck('name', 'id')
            ->toArray();

        return $datas;
    }

}
