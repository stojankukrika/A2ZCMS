@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} ::
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
<div class="col-md-12">
		<div class="box">
			<div class="box-header">
					<h2><i class="icon-th"></i><span class="break"></span>{{{ $title }}}: {{ $user->name }} {{ $user->surname }}</h2>
				</div>
				<div class="box-content">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane active">
							
							<table id="users" class="table table-striped table-hover">
								<thead>
									<tr>
										<th class="col-md-12">{{{ Lang::get('admin/users/table.time_login') }}}:</th>
									</tr>
								</thead>
								<tbody>
								@foreach ($historylogin as $item)
									<tr>
										<th class="col-md-12">{{{ $item->created_at }}}</th>
									</tr>
								@endforeach
								</tbody>
							</table>
							<ul class="pager">
							{{ $historylogin->links() }}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>	
@stop