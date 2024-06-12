<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\FruitItem;
use App\Enums\ItemUnit;

class InvoiceServices
{
    /**
     * @param int $comicId
     * @return mixed
     */
    public function getListInvoice(array $params = [])
    {
        $datas = Invoice::with([
                'invoiceDetails',
                'invoiceDetails.fruitItem',
                'invoiceDetails.fruitItem.fruitCategory',
            ])->paginate(20);

        return $datas;
    }

    public function createOrUpdateInvoice(array $inputs = [], string $idFruitItem = '')
    {
        if (!empty($idFruitItem)) {
            $invoice = Invoice::find($idFruitItem);

        } else {
            $invoice = new Invoice();
            $invoice->invoice_no = $this->generateInvoiceCode();
        }
        $totalQty = array_sum(array_values($inputs['quantity']));
        $invoice->customer_name  = $inputs['customer_name'];
        $invoice->total_quantity = $totalQty;

        $invoice->save();

        $items = FruitItem::whereIn('id', array_values($inputs['items']))->get();
        // data invoice details
        $detailInvoices = [];
        $totalAmount = 0;
        foreach ($inputs['items'] as $key => $idItem) {
            $price = 0;
            foreach ($items as $item) {
                if ($idItem == $item->id) {
                    $price = $item->price;
                }
            }
            $quantity = $inputs['quantity'][$key];
            $amount = $price * $quantity;
            $totalAmount += $amount;
            $detailInvoices[] = [
                'invoice_id'    => $invoice->getKey(),
                'fruit_item_id' => $idItem,
                'quantity'      => $quantity,
                'amount'        => $amount
            ];
        }

        $invoice->total_amount   = $totalAmount;
        $invoice->save();

        $invoice->invoiceDetails()->delete();

        InvoiceDetail::insert($detailInvoices);

        return $invoice;
    }

    public function getDetail(string $idInvoice = '')
    {
        return Invoice::where('id', $idInvoice)
            ->with([
                'invoiceDetails',
                'invoiceDetails.fruitItem',
                'invoiceDetails.fruitItem.fruitCategory',
                'invoiceDetails.fruitItem.fruitCategory.fruitItems',
            ])
            ->first();
    }

    private function generateInvoiceCode()
    {
        $orderCount = Invoice::count();
        return 'INVOICE-' . str_pad($orderCount + 1, 6, '0', STR_PAD_LEFT);
    }

}
