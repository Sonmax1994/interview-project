@extends('admin.layouts')

@section('title_page', 'Fruit Item')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
            <h1 class="m-0">Fruit Item</h1>
            </div>
            <div class=" col-sm-2">
            	<div class="row col-sm-8">
	        		<a href="{{ route('invoice.create') }}" class="btn btn-block btn-success btn-sm">
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
				            <th class="col-sm-3 text-center">Customer Name</th>
				            <th class="col-sm-2 text-center">Invoice No</th>
				            <th class="col-sm-2 text-center">Total Quantity</th>
				            <th class="col-sm-2 text-center">Total Amount</th>
				            <th class="col-sm-2 text-center"></th>
			         	</tr>
			      	</thead>
			      	<tbody>
			      		@if (count($listInvoices))
			      			@foreach ($listInvoices as $key => $item)
				      			<tr>
						            <td class=" text-center">{{ $key + 1 }}</td>
						            <td class=" text-center">{{ $item->customer_name }}</td>
						            <td class=" text-center">{{ $item->invoice_no }}</td>
						            <td class=" text-center">{{ $item->total_quantity }}</td>
						            <td class=" text-center">{{ $item->total_amount }}</td>
						            
						            <td class=" text-center">
						            	<div class="row">
						            		<div class="col-sm-3 col-xs-4">
						            			<a target="_blank" href="{{route('invoice.filePdfInvoice', ['id' => $item->getKey()])}}" class="btn btn-success btn-sm">
								        			<i class="fas fa-download"></i>
								        		</a>
						            		</div>
						            		<div class="col-sm-3 col-xs-4">
									            <a href="{{ route('invoice.show', ['id' => $item->getKey()]) }}" class="btn btn-primary btn-sm">
								        			<i class="fas fa-edit"></i>
								        		</a>
						            		</div>
						            		<div class="col-sm-3 col-xs-4">
						            			<form action="{{ route('invoice.delete', $item->getKey()) }}" method="POST">
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
					            <td  colspan="5" class=" text-center">Data Not Found</td>
				         	</tr>
			      		@endif
			      	</tbody>
			   	</table>
			   	{{ $listInvoices->links(); }}
			</div>
		</div>
    </div>
</section>
@endsection
