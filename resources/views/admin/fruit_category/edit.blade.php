@extends('admin.layouts')

@section('title_page', 'Fruit Category')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
                <h1 class="m-0">Fruit Category <span style="font-size: 22px; color: blue">Edit</span></h1>
            </div>
            <div class="col-sm-1">
                <form action="{{ route('fruit_category.delete', $fruitCategory->getKey()) }}" method="POST">
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
              <h3 class="card-title">Edit Category</h3>
           </div>
           <form action="{{ route('fruit_category.edit', ['id' => $fruitCategory->getKey()]) }}" method="post" id="quickForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group col-sm-6">
                        <label for="fruitCateName">Name</label>
                        <input 
                            type="text"
                            class="form-control "
                            id="fruitCateName" 
                            placeholder="Fruit Category Name"
                            name='name'
                            value="{{ $fruitCategory->name }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="descriptions">Descriptions</label>
                        <textarea
                            class="form-control"
                            id="descriptions" 
                            name='descriptions'
                            >{{ $fruitCategory->descriptions }}</textarea> 
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{ route('fruit_category') }}" class="btn btn-success">Back</a>
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
        name: {
            required: true,
        }
    },
    messages: {
        name: {
            required: "Please enter a name for fruit category",
        }
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