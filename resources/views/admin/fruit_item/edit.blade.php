@extends('admin.layouts')

@section('title_page', 'Fruit Item')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
                <h1 class="m-0">Fruit Item <span style="font-size: 22px; color: blue">Edit</span></h1>
            </div>
            <div class="col-sm-1">
                <form action="{{ route('fruit_item.delete', $fruitItem->getKey()) }}" method="POST">
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
           <div class="card-header">
              <h3 class="card-title">Edit Item</h3>
           </div>
           <form action="{{ route('fruit_item.edit', ['id' => $fruitItem->getKey()]) }}"
                method="POST" id="quickForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for='categoryIdSelect'>Fruit Category</label>
                            <select class="form-control select2bs4"
                                style="width: 100%;"
                                name='category_id' id="categoryIdSelect">
                                <option value=''>--- Selected Fruit Category ---</option>
                                @foreach ($optionListCategoryFruit as $key => $value)
                                    <option value="{{$key}}" {{ $fruitItem->category_id == $key ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="fruitItemName">Name</label>
                        <input 
                            type="text"
                            class="form-control "
                            id="fruitItemName" 
                            placeholder="Fruit Item Name"
                            name='name'
                            value="{{ $fruitItem->name }}">
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unitSelected">Unit</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="unit" id="unitSelected">
                                <option value=''>--- Selected Item ---</option>
                                @foreach ($optionUnitItem as $key=>$unit)
                                    <option value="{{$key}}" {{$fruitItem->unit->value == $key ? 'selected' : ''}}>{{$unit}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="fruitPriceName">Price</label>
                        <input 
                            type="text"
                            class="form-control "
                            id="fruitPriceName" 
                            placeholder="Fruit Item Price"
                            name='price'
                            value="{{ $fruitItem->price }}">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('fruit_item') }}" class="btn btn-success">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
$(function () {
  $('#quickForm').validate({
    rules: {
        category_id: {
            required: true,
        },
        name: {
            required: true,
        },
        unit: {
            required: true,
        },
        price: {
            required: true,
        }
    },
    messages: {
        category_id: {
            required: "Please selected a fruit category",
        },
        name: {
            required: "Please enter a name",
        },
        unit: {
            required: "Please selected a unit",
        },
        price: {
            required: "Please enter a price",
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