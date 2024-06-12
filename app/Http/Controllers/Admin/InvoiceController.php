<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FruitItemServices;
use App\Services\FruitCategoryServices;
use App\Services\InvoiceServices;
use App\Http\Requests\Invoice\CreateInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use Illuminate\Support\Facades\DB;
use App\Enums\ItemUnit;
use PDF;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->fruitItemServices = new FruitItemServices;
        $this->fruitCategoryServices = new FruitCategoryServices;
        $this->invoiceServices = new InvoiceServices;
    }

    public function index(Request $request)
    {
        $data = $this->invoiceServices->getListInvoice();

        return view('admin.invoice.index', [
            'listInvoices' => $data
        ]);
    }

    public function create()
    {
    	$optionListCategoryFruit = $this->fruitCategoryServices->optionListCategoryFruit();

        return view('admin.invoice.create', [
        	'optionListCategoryFruit' => $optionListCategoryFruit
        ]);
    }

    public function store(CreateInvoiceRequest $request)
    {
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            $invoice = $this->invoiceServices->createOrUpdateInvoice($inputs);
            DB::commit();

            return redirect()->route('invoice.show', ['id' => $invoice->getKey()]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Request $request)
    {
        $idInvoice = $request->id;
        $data = $this->invoiceServices->getDetail($idInvoice);
        $optionListCategoryFruit = $this->fruitCategoryServices->optionListCategoryFruit();

        return view('admin.invoice.edit', [
			'invoice'           => $data,
			'optionListCategoryFruit' => $optionListCategoryFruit
        ]);
    }

    public function edit(UpdateInvoiceRequest $request)
    {
        $idInvoice = $request->id;
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            $fruitItem = $this->invoiceServices->createOrUpdateInvoice($inputs, $idInvoice);
            DB::commit();

            return redirect()->route('invoice.show', ['id' => $fruitItem->getKey()]);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Request $request)
    {
        $idInvoice = $request->id;
        DB::beginTransaction();
        try {
            $data = $this->invoiceServices->getDetail($idInvoice);
            $data->invoiceDetails()->delete();
            $data->delete();
            DB::commit();

            return redirect()->route('invoice');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function exportFile(Request $request)
    {
        $idInvoice = $request->invoiceId;
        DB::beginTransaction();
        try {
            $detail = $this->invoiceServices->getDetail($idInvoice);
            $pdf = PDF::loadView(
	            'admin.invoice.invoice-pdf',
	            [
	                'detail' => $detail,
	            ]
	        )->setPaper('a4');
        	return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function filePdfInvoice(Request $request)
    {
        $idInvoice = $request->id;
        DB::beginTransaction();
        try {
            $detail = $this->invoiceServices->getDetail($idInvoice);
            $pdf = PDF::loadView(
	            'admin.invoice.invoice-pdf',
	            [
	                'detail' => $detail,
	            ]
	        )->setPaper('a4');
	        return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
