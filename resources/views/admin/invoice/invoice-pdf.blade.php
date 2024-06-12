<html>

<head>
    <style>
        #detail .custom tr th {
            text-align: center;
            border-top: 1px solid;
            border-bottom: 1px solid;
            height: 25px;
            color: #a67216
        }
        #detail .custom tr td {
            height: 23px
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        tfoot {
            border-top: 1px solid #a67216;
        }
        .pre-wrap-text {
            white-space : pre-line;
        }
        .table-customer {
        }
        #detail .table-customer tr td {
            border-bottom: 0.5px solid;
        }
    </style>
</head>

<body style="padding-top: 70px">
    <div id="detail">
        <table class="r" style="border-collapse: collapse;width: 720px; margin-bottom: 30px" >
            <tbody>
                <tr>
                    <td class="text-center" style="font-size: 32px;font-weight: bold;color: blue;">Invoice Detail</td>
                </tr>
            </tbody>
            
        </table>
        <table class="table-customer" style="border-collapse: collapse;width: 320px; margin-bottom: 20px" >
            <tbody>
                <tr>
                    <td class="text-center" style="width: 23%;font-weight: bold;"> <span style="color: #a67216">Customer :</span></td>
                    <td class="text-center pre-wrap-text" style="width: 55%">{{ $detail->customer_name }}</td>
                </tr>
                <tr>
                    <td class="text-center" style="font-weight: bold;" > <span style="color: #a67216">Invoice No :</span> </td>
                    <td class="text-center pre-wrap-text" style="width: 55%">{{ $detail->invoice_no }}</td>
                </tr>
                <tr>
                    <td class="text-center" style="font-weight: bold;" ><span style="color: #a67216">Date Create : </span></td>
                    <td class="text-center pre-wrap-text" style="width: 55%">{{ date('Y-m-d', strtotime($detail->created_at)) }}</td>
                </tr>
            </tbody>
            
        </table>

        <table class="custom" style="border-collapse: collapse;width: 720px" >
            <thead>
                <tr>
                    <th style="width: 10%">No</th>
                    <th style="width: 25%">Category Name</th>
                    <th style="width: 25%">Fruit Item</th>
                    <th style="width: 10%">Unit</th>
                    <th style="width: 10%">Price</th>
                    <th style="width: 10%">Quantity</th>
                    <th style="width: 10%">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail->invoiceDetails as $index=>$data)
                <tr>
                    <td class="text-center" >{{ $index+1 }}</td>
                    <td class="text-center pre-wrap-text">{{ $data->fruitItem->fruitCategory->name }}</td>
                    <td class="text-center pre-wrap-text">{{ $data->fruitItem->name }}</td>
                    <td class="text-center">{{ $data->fruitItem->unit->getLabel() }}</td>
                    <td class="text-center">{{ $data->fruitItem->price }}</td>
                    <td class="text-center">{{ $data->quantity }}</td>
                    <td class="text-center">${{ $data->amount }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-size: 18px;padding-top: 10px; height: 27px;color: blue;">
                    <td class=" text-right" colspan="6" >Total Amount</td>
                    <td class="text-center" id="total_amount">
                        ${{ $detail->total_amount }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script type="text/php">
        
    </script>
</body>

</html>
