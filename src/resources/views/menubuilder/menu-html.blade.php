@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Menu builder
      </h1>
    </section>

@endsection

@section('after_styles')
<link href="{{asset('vendor/menubuilder/style.css')}}" rel="stylesheet">
@endsection

@section('content')

@php $currentUrl = url()->current(); @endphp
<div id="hwpwrap">
	<div class="custom-wp-admin wp-admin wp-core-ui js   menu-max-depth-0 nav-menus-php auto-fold admin-bar">
		<div id="wpwrap">
			<div id="wpcontent">
				<div id="wpbody">
					<div id="wpbody-content">
						<div class="wrap">
              <!-- ============================= -->
              <div class="row">
              	<div class="col-md-12">
              		<div class="box box-default">
              			<div class="box-header">
              				<form method="get" action="{{ $currentUrl }}" class="form-horizontal" role="form">
                        <div class="form-group-nostyle">
                          <label for="menu-dropdown" class="col-md-2 control-label">Select menu to edit:</label>
                          <div class="col-md-2">
                            {!! Menu::select('menu', $menulist) !!}
                          </div>
                          <div class="col-md-1">
                            <input type="submit" class="btn btn-primary ladda-button" value="Select">
                          </div>
                          <div class="col-md-7">
                            <h4><span> or <a href="{{ $currentUrl }}?action=edit&menu=0">Create new menu</a>. </span></h4>
                          </div>
                        </div>
              				</form>
              			</div>
              		</div>
              	</div>
              </div>
              <div class="row">
              	<div class="col-md-4">
              		<div class="panel-group">
              			@if(request()->has('menu')  && !empty(request()->input("menu")))
              		  <div class="box box-default">
              		    <div class="box-header with-border">
              		      <h4 class="box-title">
              		        <a data-toggle="collapse" href="#collapse1"><i class="fa fa-plus"></i> Custom Link</a>
              		      </h4>
              		    </div>
              		    <div id="collapse1" class="panel-collapse collapse in">
              		      <div class="box-body">
              						<div class="form-group">
              							<label for="custom-menu-item-url">URL: </label>
              							<input id="custom-menu-item-url" name="url" type="text" class="form-control" value="http://">
              						</div>
              						<div class="form-group">
              							<label for="custom-menu-item-name">Label Text: </label>
              							<input id="custom-menu-item-name" name="label" type="text" class="form-control" title="Label menu">
              						</div>
              						<div class="form-group">
              							<a href="#" class="btn btn-primary ladda-button" onclick="addcustommenu()"><span class="spinner" id="spincustomu"></span>Add menu item</a>
              						</div>
              					</div>
              		    </div>
              		  </div>
              			@endif
              		</div>

                  <div class="panel-group">
              			@if(request()->has('menu')  && !empty(request()->input("menu")))
              		  <div class="box box-default">
              		    <div class="box-header with-border">
              		      <h4 class="box-title">
              		        <a data-toggle="collapse" href="#collapse2"><i class="fa fa-plus"></i> From Routes</a>
              		      </h4>
              		    </div>
              		    <div id="collapse2" class="panel-collapse collapse in">
              		      <div class="box-body">
              						<div class="form-group">
              							<label for="custom-menu-item-route-url">Route: </label>
                            <select class="form-control" id="custom-menu-item-route-url" name="route">
                              @foreach(Route::getRoutes()->get('GET') as $route)
                                @if(strpos($route->uri,'admin') == false && strpos($route->uri,'{') == false)
                                  <option value="{{ config('menu.domain').str_replace(app()->getLocale(),'',str_replace(app()->getLocale().'/','',$route->uri)) }}">{{ str_replace(app()->getLocale(),'',$route->uri) }}</option>
                                @endif
                              @endforeach
                            </select>
              						</div>
              						<div class="form-group">
              							<label for="custom-menu-item-route-name">Label Text: </label>
              							<input id="custom-menu-item-route-name" name="label" type="text" class="form-control" title="Label menu">
              						</div>
              						<div class="form-group">
              							<a href="#" class="btn btn-primary ladda-button" onclick="addcustommenuroute()">Add menu item</a>
              						</div>
              					</div>
              		    </div>
              		  </div>
              			@endif
              		</div>

              	</div>
              	<div class="col-md-8">
              		<div class="box box-default">
              				<div class="box-body">
              					<form id="update-nav-menu" action="" method="post" enctype="multipart/form-data" class="form-vertical" role="form">
              						<div class="menu-edit ">
              							<div class="box-header with-border">
                              <div class="form-group">
                                <label class="col-md-1 control-label" for="menu-name">Name</label>
                                <div class="col-md-5">
                                  <input name="menu-name" id="menu-name" type="text" class="form-control" title="Enter menu name" value="@if(isset($indmenu)){{$indmenu->name}}@endif">
                  								<input type="hidden" id="idmenu" value="@if(isset($indmenu)){{$indmenu->id}}@endif" />
                                </div>
                                <div class="col-md-6">
                                  @if(request()->has('action'))
                										<a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="btn btn-primary ladda-button">Create menu</a>
                									@elseif(request()->has("menu"))
                										<a onclick="getmenus()" name="save_menu" id="save_menu_header" class="btn btn-primary ladda-button"><span class="spinner" id="spincustomu2"></span>Save menu</a>
                									@else
                										<a onclick="createnewmenu()" name="save_menu" id="save_menu_header" class="btn btn-primary ladda-button">Create menu</a>
                									@endif
                                </div>
                              </div>
              							</div>
              							<div id="post-body">
              								<div id="post-body-content">

              									@if(request()->has("menu"))
              									<h3>Menu Structure</h3>
              									<div class="drag-instructions post-body-plain" style="">
              										<p>
              											Place each item in the order you prefer. Click on the arrow to the right of the item to display more configuration options.
              										</p>
              									</div>

              									@else
              									<h3>Menu Creation</h3>
              									<div class="drag-instructions post-body-plain" style="">
              										<p>
              											Please enter the name and select "Create menu" button
              										</p>
              									</div>
              									@endif

              									<ul class="menu ui-sortable" id="menu-to-edit">
              										@if(isset($menus))
              										@foreach($menus as $m)
              										<li id="menu-item-{{$m->id}}" class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending" style="display: list-item;">
              											<dl class="menu-item-bar">
              												<dt class="menu-item-handle">
              													<span class="item-title"> <span class="menu-item-title"> <span id="menutitletemp_{{$m->id}}">{{$m->label}}</span> <span style="color: transparent;">|{{$m->id}}|</span> </span> <span class="is-submenu" style="@if($m->depth==0)display: none;@endif">Subelement</span> </span>
              													<span class="item-controls"> <span class="item-type">Link</span> <span class="item-order hide-if-js"> <a href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-up"><abbr title="Move Up">↑</abbr></a> | <a href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-down"><abbr title="Move Down">↓</abbr></a> </span> <a class="item-edit" id="edit-{{$m->id}}" title=" " href="{{ $currentUrl }}?edit-menu-item={{$m->id}}#menu-item-settings-{{$m->id}}"> </a></span>
              												</dt>
              											</dl>

              											<div class="menu-item-settings" id="menu-item-settings-{{$m->id}}">
              												<div class="form-group">
                                        <input type="hidden" class="edit-menu-item-id" name="menuid_{{$m->id}}" value="{{$m->id}}" />
                                        <label for="edit-menu-item-title-{{$m->id}}"> Label</label>
              													<input type="text" id="idlabelmenu_{{$m->id}}" class="form-control edit-menu-item-title" name="idlabelmenu_{{$m->id}}" value="{{$m->label}}">
              												</div>

              												<div class="form-group">
              													<label for="edit-menu-item-classes-{{$m->id}}"> Class CSS (optional)</label>
              													<input type="text" id="clases_menu_{{$m->id}}" class="form-control edit-menu-item-classes" name="clases_menu_{{$m->id}}" value="{{$m->class}}">
              												</div>

              												<div class="form-group">
              													<label for="edit-menu-item-url-{{$m->id}}"> Url</label>
              													<input type="text" id="url_menu_{{$m->id}}" class="form-control edit-menu-item-url" id="url_menu_{{$m->id}}" value="{{$m->link}}">
              												</div>

              												<!-- <div class="form-group">
              													<label><a href="{{ $currentUrl }}" class="menus-move-up btn btn-link" style="display: none;">Move up</a> <a href="{{ $currentUrl }}" class="menus-move-down btn btn-link" title="Mover uno abajo" style="display: inline;">Move Down</a> <a href="{{ $currentUrl }}" class="menus-move-left btn btn-link" style="display: none;"></a> <a href="{{ $currentUrl }}" class="menus-move-right btn btn-link" style="display: none;"></a> <a href="{{ $currentUrl }}" class="menus-move-top" style="display: none;">Top</a> </label>
              												</div> -->

              												<div class="menu-item-actions description-wide submitbox">

              													<a class="item-delete submitdelete deletion btn btn-danger" id="delete-{{$m->id}}" href="{{ $currentUrl }}?action=delete-menu-item&menu-item={{$m->id}}&_wpnonce=2844002501">Delete</a>
              													<span class="meta-sep hide-if-no-js"> | </span>
              													<a class="item-cancel submitcancel hide-if-no-js button-secondary btn btn-default" id="cancel-{{$m->id}}" href="{{ $currentUrl }}?edit-menu-item={{$m->id}}&cancel=1424297719#menu-item-settings-{{$m->id}}">Close</a>
              													<span class="meta-sep hide-if-no-js"> | </span>
              													<a onclick="updateitem({{$m->id}})" class="button button-primary updatemenu btn btn-primary" id="update-{{$m->id}}" href="javascript:void(0)">Update item</a>

              												</div>

              											</div>
              											<ul class="menu-item-transport"></ul>
              										</li>
              										@endforeach
              										@endif
              									</ul>
              									<div class="menu-settings">

              									</div>
              								</div>
              							</div>
              						</div>
              					</form>
              			</div>
                    <div class="box-footer">
                      @if(request()->get('menu') != '0' && request()->has('menu'))
                      <h4 class="pull-right"><span class="delete-action"> <a class="btn btn-danger" onclick="deletemenu()" href="javascript:void(9)">Delete menu</a> </span></h4>
                      @endif
                    </div>
              		</div>
              	</div>
              </div>
              <!-- ============================= -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('after_scripts')
	@include('vendor.menubuilder.scripts')
@endsection
