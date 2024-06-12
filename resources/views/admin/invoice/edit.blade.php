@extends('admin.layouts')

@section('title_page', 'Invoice')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
            <h1 class="m-0">Invoice <span style="font-size: 22px; color: blue">Edit</span></h1>
            </div>
            <div class="col-sm-1">
                <form action="{{ route('invoice.delete', $invoice->getKey()) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
           <div class="card-header col-sm-10">
              <h3 class="card-title">Edit Invoice</h3>
           </div>
           <div class="col-sm-10">
               <form action="{{ route('invoice.edit', ['id' => $invoice->getKey()]) }}" method="post" id="quickForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td class=" text-center"> Customer </td>
                                <td class=" text-center">
                                    <input 
                                        type="text"
                                        class="form-control "
                                        id="customerNameId" 
                                        placeholder="Customer Name"
                                        name='customer_name'
                                        value="{{ $invoice->customer_name }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-hover" id=myTable>
                        <thead>
                            <tr>
                                <th class=" text-center col-sm-1"> No </th>
                                <th class=" text-center col-sm-3"> Category </th>
                                <th class=" text-center col-sm-3"> Fruit </th>
                                <th class=" text-center col-sm-1"> Unit </th>
                                <th class=" text-center col-sm-1"> Price </th>
                                <th class=" text-center col-sm-1"> Quantity </th>
                                <th class=" text-center col-sm-1"> Amount </th>
                                <th class=" text-center col-sm-1">  </th>
                            </tr>
                        </thead>
                        <tbody id="tBody">
                            @if (count($invoice->invoiceDetails))
                            @foreach ($invoice->invoiceDetails as $key => $detail)
                            <tr id="row_{{$key+1}}" key="{{$key+1}}">
                                <td class="" >{{$key+1}}</td>
                                <td>
                                    <select class="form-control select2bs4" 
                                        style="width: 100%;" name="cate[{{$key + 1}}]" id="cateSelected_{{$key + 1}}"
                                        onChange="selectFruitCategory(this.options[this.selectedIndex].value, {{ $key + 1 }})">
                                        <option value="">--- Selected Item ---</option>
                                        @foreach ($optionListCategoryFruit as $indexCate => $cate)
                                            <option value="{{$indexCate}}"
                                            {{ $detail->fruitItem->fruitCategory->id == $indexCate ? "selected" : "" }}
                                            >
                                                {{ $cate }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select
                                        class="form-control select2bs4" style="width: 100%;"
                                        name="items[{{$key+1}}]" id="itemSelected_{{$key+1}}" 
                                        onChange="selectFruitItem(this.options[this.selectedIndex].value, {{$key+1}})">
                                        <option value="">--- Selected Item ---</option>
                                        @foreach ($detail->fruitItem->fruitCategory->fruitItems as $k2=>$val2)
                                            <option value="{{$val2->id}}" {{$val2->id == $detail->fruit_item_id ? 'selected' : ''}}>{{$val2->name}}</option> 
                                        @endforeach
                                    </select>
                                </td>
                                <td><span id="itemUnit_{{$key+1}}">{{$detail->fruitItem->unit->getLabel()}}</span></td>
                                <td><span id="itemPrice_{{$key+1}}">{{$detail->fruitItem->price}}</span></td>
                                <td>
                                    <input type="text" 
                                        class="form-control" id="quantityId_{{$key+1}}"
                                        placeholder="Quantity Name" name="quantity[{{$key+1}}]" 
                                        value="{{ $detail->quantity }}"
                                        onChange="operateAmount(this.value, {{$key+1}})">
                                </td>
                                <td><span id="amount_{{$key+1}}">{{$detail->amount}}</span></td>
                                <td >
                                    <button type="button" class="btn btn-success btn-xs"
                                    onclick="removeItem('{{$key+1}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            
                        </tbody>
                        <tfoot>
                            <tr id="total_row">
                                <td class=" text-right" colspan="6">Total Amount</td>
                                <td class="" id="total_amount">
                                    {{ $invoice->total_amount }}
                                </td>
                                <td class="">
                                    <input type="hidden" id="totalIndexRow" name="totalIndexRow" value="{{count($invoice->invoiceDetails)}}">
                                    <button type="button" class="btn btn-primary btn-xs" onclick="addItem(this)"><i class="nav-icon fas fa-plus"></i></button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="card-footer">
                        <a href="{{ route('invoice') }}" class="btn btn-success">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function addItem(n)
{
    var tBody = document.getElementById("tBody");
    var rows = tBody.getElementsByTagName('tr');
    var indexTable = 0;
    var keyTable = 0;
    for (var i = 0; i < rows.length; i++) {
        var newIndexRow = i+1;
        var keyCol = rows[i].getElementsByTagName('td')[0].innerText;
        if (keyCol != 'undefined' && keyCol > indexTable) {
            indexTable = keyCol;
        }
        var keyMax = rows[i].getAttribute('key');
        if (parseInt(keyMax) > keyTable) {
            keyTable = keyMax;
        }
    }
    var row = tBody.insertRow(indexTable);

    var nextKeyRow = parseInt(keyTable) + 1;
    
    row.setAttribute("key", nextKeyRow);
    row.setAttribute("id", 'row_'+nextKeyRow);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
    cell1.innerHTML = parseInt(indexTable) + 1;
    cell2.innerHTML = '<td><select class="form-control select2bs4" style="width: 100%;" name="cate[' + nextKeyRow + ']" id="cateSelected_' + nextKeyRow + '" onChange="selectFruitCategory(this.options[this.selectedIndex].value, ' + nextKeyRow + ')"><option value="">--- Selected Item ---</option>@foreach ($optionListCategoryFruit as $key=>$cate)<option value="{{ $key }}">{{ $cate }}</option>@endforeach</select></td>';

    cell3.innerHTML = '<td><select class="form-control select2bs4" style="width: 100%;" name="items[' +nextKeyRow+ ']" id="itemSelected_' + nextKeyRow + '" onChange="selectFruitItem(this.options[this.selectedIndex].value, ' + nextKeyRow + ')"> <option value="">--- Selected Item ---</option> </select></td>';
    cell4.innerHTML = '<td><span id="itemUnit_' + nextKeyRow + '"></span></td>';
    cell5.innerHTML = '<td><span id="itemPrice_' + nextKeyRow + '"></span></td>';
    cell6.innerHTML = '<td ><input type="text" class="form-control" id="quantityId_' + nextKeyRow + '" placeholder="Quantity Name" name="quantity['+nextKeyRow+']" value="" onChange="operateAmount(this.value,' + nextKeyRow + ')"></td>';
    cell7.innerHTML = '<td><span id="amount_' + nextKeyRow + '">0</span></td>';
    cell8.innerHTML = '<td ><button type="button" class="btn btn-success btn-xs" onclick="removeItem(' + nextKeyRow + ')"><i class="fas fa-trash-alt"></i></button></td>';
}

function selectFruitCategory(categoryId, indexRow) {
    $.ajax(
        {
        url: '{{ route("fruit_item.getItemsByCategoryId") }}',
        type: 'post',
        dataType: "json",
        data: 
        {
           'category_id': categoryId,
           "_token": "{{ csrf_token() }}"
        },
        success: function (datas) 
        {
            $("#itemUnit_" + indexRow).html('');
            $("#itemPrice_" + indexRow).html('');
            $("#amount_" + indexRow).html(0);
            document.getElementById("quantityId_" + indexRow).value = '';

            var selectOptionHtml = "<option value=''>--- Selected Item ---</option>";
            if (datas.length > 0 || Object.keys(datas).length > 0) {
                for (const [key, value] of Object.entries(datas)) {
                    selectOptionHtml += "<option value='" + key + "'>" + value +"</option>";
                }
            }
            $("#itemSelected_" + indexRow).html(selectOptionHtml);
            totalAmount();
        }
    });
}

function selectFruitItem(itemId, indexRow) {
    $.ajax(
        {
        url: '{{ route("fruit_item.detail_item") }}',
        type: 'post',
        dataType: "json",
        data: 
        {
            'itemId': itemId,
            "_token": "{{ csrf_token() }}"
        },
        success: function (data) 
        {
            var itemUnit = '';
            var itemPrice = 0;
            if (data.length > 0 || Object.keys(data).length > 0) {
                itemUnit = data.unit_label;
                itemPrice = data.price;
            }
            $("#itemUnit_" + indexRow).html(itemUnit);
            $("#itemPrice_" + indexRow).html(itemPrice);
            $("#amount_" + indexRow).html(0);
            document.getElementById("quantityId_" + indexRow).value = '';
            totalAmount();
        }
    });
}

function removeItem(indexRow)
{
    const element = document.getElementById("row_" + indexRow);

    element.remove();

    var tBody = document.getElementById("tBody");
    var rows = tBody.getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var newIndexRow = i+1;
        rows[i].getElementsByTagName('td')[0].innerText = newIndexRow;

    }
    totalAmount();
}

function operateAmount(quantity, indexRow)
{
    var price = document.getElementById('itemPrice_' + indexRow).innerHTML;
    document.getElementById("amount_" + indexRow).innerHTML = price * quantity;
    totalAmount();
}

function totalAmount()
{
    var tBody = document.getElementById("tBody");
    var rows = tBody.getElementsByTagName('tr');
    var totalAmount = 0;
    for (var i = 0; i < rows.length; i++) {
        var index = parseInt(i) + 1;
        var amountElement = rows[i].getElementsByTagName('td')[6].getElementsByTagName('span')[0].innerHTML;
        
        totalAmount = parseInt(totalAmount) + parseInt(amountElement);
    }
    document.getElementById('total_amount').innerHTML = totalAmount
}

function exportFile()
{
    var invoiceId = "{{$invoice->getKey()}}";
    $.ajax(
        {
        url: '{{ route("invoice.exportFile") }}',
        type: 'post',
        dataType: "json",
        data: 
        {
            'invoiceId': invoiceId,
            "_token": "{{ csrf_token() }}"
        },
        success: function (data) 
        {
            
        }
    });
}

$(function () {
  $('#quickForm').validate({
    rules: {
        customer_name: {
            required: true,
        },
    },
    messages: {
        customer_name: {
            required: "Please enter a customer name",
        },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
  });
});
</script>
@endsection