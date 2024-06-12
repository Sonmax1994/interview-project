@extends('admin.layouts')

@section('title_page', 'Fruit Category')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
            <h1 class="m-0">Fruit Category</h1>
            </div>
            <div class=" col-sm-2">
            	<div class="row col-sm-8">
	        		<a href="{{ route('fruit_category.create') }}" class="btn btn-block btn-success btn-sm">
	        			<i class="nav-icon fas fa-plus"></i> Create
	        		</a>
            	</div>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
    	<div class="card">
			<div class="card-body p-0">
			   <table class="table table-striped">
			      <thead>
			         	<tr>
				            <th class="col-sm-1 text-center">#</th>
				            <th class="col-sm-3 text-center">Name</th>
				            <th class="col-sm-6 text-center">Descriptions</th>
				            <th class="col-sm-2 text-center">Action</th>
			         	</tr>
			      	</thead>
			      	<tbody>
			      		@if (count($listFruitCategory))
			      			@foreach ($listFruitCategory as $key => $item)
				      			<tr>
						            <td class=" text-center">{{ $key + 1 }}</td>
						            <td class=" text-center">{{ $item->name }}</td>
						            <td class=" ">
						               {{ $item->descriptions }}
						            </td>
						            <td class=" text-center">
						            	<div class="row">
						            		<div class="col-sm-2"></div>
						            		<div class="col-sm-4">
									            <a href="{{ route('fruit_category.show', ['id' => $item->getKey()]) }}" class="btn btn-primary btn-sm">
								        			<i class="fas fa-edit"></i>
								        		</a>
						            		</div>
						            		<div class="col-sm-4">
						            			<form action="{{ route('fruit_category.delete', $item->getKey()) }}" method="POST">
												    @csrf
												    @method('delete')
												    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
												    	<i class="fas fa-trash-alt"></i>
												    </button>
												</form>
								        		
						            		</div>
						            	</div>
						            </td>
					         	</tr>
			      			@endforeach
			      		@else
				         	<tr >
					            <td  colspan="4" class=" text-center">Data Not Found</td>
				         	</tr>
			      		@endif
			      	</tbody>
			   	</table>
			   	{{ $listFruitCategory->links(); }}
			   	<!-- <div class="card-footer clearfix">
					<ul class="pagination pagination-sm m-0 float-right">
						<li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
					</ul>
              	</div> -->
			</div>
		</div>
    </div>
</section>
@endsection