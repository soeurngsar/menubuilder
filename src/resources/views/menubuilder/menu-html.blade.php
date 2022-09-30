@extends(backpack_view('blank'))

@section('header')
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h1>{{ trans('wmenu::menu.menuBuilder') }}</h1>
        </div>
    </section>
@endsection

@section('after_styles')
    <link href="{{asset('vendor/menubuilder/style.css')}}" rel="stylesheet">
@endsection

@section('content')
    @php $currentUrl = url()->current(); @endphp
    <div id="hwpwrap">
        <div class="custom-wp-admin wp-admin wp-core-ui js  menu-max-depth-0 nav-menus-php auto-fold admin-bar">
            <div id="wpwrap">
                <div id="wpcontent">
                    <div id="wpbody">
                        <div id="wpbody-content">
                            <div class="wrap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <form
                                                    method="get"
                                                    action="{{ $currentUrl }}"
                                                    class="form-horizontal"
                                                    role="form"
                                                >
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <div class="pr-3">
                                                            <h5
                                                                for="menu-dropdown"
                                                                class="control-label mb-0"
                                                            >{{ trans('wmenu::menu.selectToEdit') }}:</h5>
                                                        </div>
                                                        <div class="pr-3 flex-grow-1">
                                                            {!! Menu::select('menu', $menulist) !!}
                                                        </div>
                                                        <div class="pr-3">
                                                            <input
                                                                type="submit"
                                                                class="btn btn-primary ladda-button"
                                                                value="{{ trans('wmenu::menu.select') }}"
                                                            >
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">
                                                                <span> or <a href="{{ $currentUrl }}?action=create&menu=0">{{ trans('wmenu::menu.createNewMenu') }}</a>. </span>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="{{ request()->get('menu') ? 'col-md-4' : 'col-md-12 d-none' }}">
                                        <div class="panel-group">
                                            @if(request()->get("menu"))
                                                <div class="card card-default">
                                                    <div class="card-header with-border">
                                                        <h5 class="card-title mb-0">
                                                            <a
                                                                class="d-block"
                                                                data-toggle="collapse"
                                                                href="#custom-link-panel"
                                                            ><i class="la la-chevron-circle-down"></i>&nbsp;{{ trans('wmenu::menu.customLink') }}</a>
                                                        </h5>
                                                    </div>
                                                    <div id="custom-link-panel" class="panel-collapse collapse in">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="custom-menu-item-url">{{ trans('wmenu::menu.url') }}: </label>
                                                                <input
                                                                    id="custom-menu-item-url"
                                                                    name="url"
                                                                    type="text"
                                                                    class="form-control"
                                                                    value="https://"
                                                                >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="custom-menu-item-name">{{ trans('wmenu::menu.label') }}: </label>
                                                                <input
                                                                    id="custom-menu-item-name"
                                                                    name="label"
                                                                    type="text"
                                                                    class="form-control"
                                                                    title="Label menu"
                                                                >
                                                            </div>
                                                            <div class="form-group">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-primary ladda-button"
                                                                    onclick="addcustommenu()"
                                                                >
                                                                    <span class="spinner" id="spincustomu"></span>
                                                                    {{ trans('wmenu::menu.addMenuItem') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="panel-group">
                                            @if(request()->get('menu'))
                                                <div class="card card-default">
                                                    <div class="card-header with-border">
                                                        <h5 class="card-title mb-0">
                                                            <a
                                                                class="d-block"
                                                                data-toggle="collapse"
                                                                href="#internal-link-panel"
                                                            ><i class="la la-chevron-circle-down"></i>&nbsp;{{ trans('wmenu::menu.internalLink') }}</a>
                                                        </h5>
                                                    </div>
                                                    <div id="internal-link-panel" class="panel-collapse collapse in">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="custom-menu-item-route-url">{{ trans('wmenu::menu.url') }}: </label>
                                                                <select
                                                                    class="form-control"
                                                                    id="custom-menu-item-route-url"
                                                                    name="route"
                                                                >
                                                                    @foreach($routes as $route)
                                                                        @if(strpos($route->uri,'{') === false && $route->uri !== '/')
                                                                            <option value="{{ config('app.url') }}/{{ $route->uri }}">{{ config('app.url') }}/{{ $route->uri }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="custom-menu-item-route-name">{{ trans('wmenu::menu.label') }}: </label>
                                                                <input
                                                                    id="custom-menu-item-route-name"
                                                                    name="label"
                                                                    type="text"
                                                                    class="form-control"
                                                                    title="Label menu"
                                                                >
                                                            </div>
                                                            <div class="form-group">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-primary ladda-button"
                                                                    onclick="addcustommenuroute()"
                                                                >
                                                                    <span class="spinner" id="spinintmu"></span>
                                                                    {{ trans('wmenu::menu.addMenuItem') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="{{ request()->get('menu') ? 'col-md-8' : 'col-md-12' }}">
                                        <div class="card card-default">
                                            <div class="card-body">
                                                <form
                                                    id="update-nav-menu"
                                                    action=""
                                                    method="post"
                                                    enctype="multipart/form-data"
                                                    class="form-vertical"
                                                    role="form"
                                                >
                                                    <div class="menu-edit ">
                                                        <div class="form-group">
                                                            <div class="d-flex align-items-center w-100">
                                                                <div class="pr-3">{{ trans('wmenu::menu.name') }}</div>
                                                                <div class="flex-grow-1 pr-3">
                                                                    <input
                                                                        name="menu-name"
                                                                        id="menu-name"
                                                                        type="text"
                                                                        class="form-control"
                                                                        title="Enter menu name"
                                                                        value="@if(isset($indmenu)){{$indmenu->name}}@endif"
                                                                    >
                                                                    <input
                                                                        type="hidden"
                                                                        id="idmenu"
                                                                        value="@if(isset($indmenu)){{$indmenu->id}}@endif"
                                                                    />
                                                                </div>
                                                                <div>
                                                                    @if(request()->has('action'))
                                                                        <button
                                                                            type="button"
                                                                            onclick="createnewmenu()"
                                                                            name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="btn btn-primary ladda-button text-white"
                                                                        >{{ trans('wmenu::menu.createMenu') }}
                                                                        </button>
                                                                    @elseif(request()->has("menu"))
                                                                        <button
                                                                            type="button"
                                                                            onclick="getmenus()"
                                                                            name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="btn btn-primary ladda-button"
                                                                        ><span
                                                                                class="spinner"
                                                                                id="spincustomu2"
                                                                            ></span>{{ trans('wmenu::menu.saveMenu') }}
                                                                        </button>
                                                                    @else
                                                                        <button
                                                                            type="button"
                                                                            onclick="createnewmenu()"
                                                                            name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="btn btn-primary ladda-button"
                                                                        >{{ trans('wmenu::menu.createMenu') }}
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="post-body">
                                                            <div id="post-body-content">
                                                                @if(request()->get("menu"))
                                                                    <h3>{{ trans('wmenu::menu.menuStructure') }}</h3>
                                                                    <div
                                                                        class="drag-instructions post-body-plain"
                                                                        style=""
                                                                    >
                                                                        <p>{{ trans('wmenu::menu.menuStructureDescription') }}</p>
                                                                    </div>
                                                                @else
                                                                    <h3>{{ trans('wmenu::menu.menuCreation') }}</h3>
                                                                    <div
                                                                        class="drag-instructions post-body-plain"
                                                                        style=""
                                                                    >
                                                                        <p>{{ trans('wmenu::menu.menuCreationDescription') }}</p>
                                                                    </div>
                                                                @endif

                                                                <ul class="menu ui-sortable" id="menu-to-edit">
                                                                    @if(isset($menus))
                                                                        @foreach($menus as $m)
                                                                            <li
                                                                                id="menu-item-{{$m->id}}"
                                                                                class="menu-item menu-item-depth-{{$m->depth}} menu-item-page menu-item-edit-inactive pending"
                                                                                style="display: list-item;"
                                                                            >
                                                                                <dl class="menu-item-bar">
                                                                                    <dt class="menu-item-handle">
                                                                                        <span class="item-title">
                                                                                            <span class="menu-item-title">
                                                                                                <span id="menutitletemp_{{$m->id}}">{{$m->label}}</span>
                                                                                                <span style="color: transparent;">|{{$m->id}}|</span>
                                                                                            </span>
                                                                                            <span class="is-submenu" style="@if($m->depth==0)display: none;@endif">Subelement</span>
                                                                                        </span>
                                                                                        <span class="item-controls">
                                                                                            <span class="item-type">Link</span>
{{--                                                                                            <span class="item-order hide-if-js">--}}
{{--                                                                                                <a href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-up"><abbr title="Move Up">↑</abbr></a>--}}
{{--                                                                                                | <a href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{$m->id}}&_wpnonce=8b3eb7ac44" class="item-move-down"><abbr title="Move Down">↓</abbr></a>--}}
{{--                                                                                            </span>--}}
                                                                                            <a class="item-edit" id="edit-{{$m->id}}" title=" " href="{{ $currentUrl }}?edit-menu-item={{$m->id}}#menu-item-settings-{{$m->id}}">&nbsp;</a>
                                                                                        </span>
                                                                                    </dt>
                                                                                </dl>

                                                                                <div
                                                                                    class="menu-item-settings"
                                                                                    id="menu-item-settings-{{$m->id}}"
                                                                                >
                                                                                    <div class="form-group">
                                                                                        <input
                                                                                            type="hidden"
                                                                                            class="edit-menu-item-id"
                                                                                            name="menuid_{{$m->id}}"
                                                                                            value="{{$m->id}}"
                                                                                        />
                                                                                        <label for="edit-menu-item-title-{{$m->id}}"> Label</label>
                                                                                        <input
                                                                                            type="text"
                                                                                            id="idlabelmenu_{{$m->id}}"
                                                                                            class="form-control edit-menu-item-title"
                                                                                            name="idlabelmenu_{{$m->id}}"
                                                                                            value="{{$m->label}}"
                                                                                        >
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="edit-menu-item-classes-{{$m->id}}">{{ trans('wmenu::menu.cssClass') }}</label>
                                                                                        <input
                                                                                            type="text"
                                                                                            id="clases_menu_{{$m->id}}"
                                                                                            class="form-control edit-menu-item-classes"
                                                                                            name="clases_menu_{{$m->id}}"
                                                                                            value="{{$m->class}}"
                                                                                        >
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="edit-menu-item-url-{{$m->id}}">{{ trans('wmenu::menu.url') }}</label>
                                                                                        <input
                                                                                            type="text"
                                                                                            id="url_menu_{{$m->id}}"
                                                                                            class="form-control edit-menu-item-url"
                                                                                            id="url_menu_{{$m->id}}"
                                                                                            value="{{$m->link}}"
                                                                                        >
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-up btn btn-sm btn-link border mr-3"
                                                                                            style="display: none;"
                                                                                        ><i class="la la-level-up"></i></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-down btn btn-sm btn-link border mr-3"
                                                                                            title="Mover uno abajo"
                                                                                            style="display: inline;"
                                                                                        ><i class="la la-level-down"></i></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-left btn btn-sm btn-link border mr-3"
                                                                                            style="display: none;"
                                                                                        ><i class="la la-arrow-left"></i></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-right btn btn-link"
                                                                                            style="display: none;"
                                                                                        ></a> <a
                                                                                            href="{{ $currentUrl }}"
                                                                                            class="menus-move-top btn btn-sm btn-link border mr-3"
                                                                                            style="display: none;"
                                                                                        ><i class="la la-arrow-up"></i></a>
                                                                                    </div>

                                                                                    <div class="menu-item-actions description-wide submitcard">
                                                                                        <a
                                                                                            class="item-delete submitdelete deletion btn btn-sm btn-danger mr-3"
                                                                                            id="delete-{{$m->id}}"
                                                                                            href="{{ $currentUrl }}?action=delete-menu-item&menu-item={{$m->id}}&_wpnonce=2844002501"
                                                                                        >{{ trans('wmenu::menu.delete') }}</a>
                                                                                        <a
                                                                                            class="item-cancel submitcancel hide-if-no-js button-secondary btn btn-sm btn-default mr-3"
                                                                                            id="cancel-{{$m->id}}"
                                                                                            href="{{ $currentUrl }}?edit-menu-item={{$m->id}}&cancel=1424297719#menu-item-settings-{{$m->id}}"
                                                                                        >{{ trans('wmenu::menu.close') }}</a>
                                                                                        <a
                                                                                            onclick="updateitem({{$m->id}})"
                                                                                            class="button button-primary updatemenu btn btn-primary btn-sm"
                                                                                            id="update-{{$m->id}}"
                                                                                            href="javascript:void(0)"
                                                                                        >{{ trans('wmenu::menu.updateItem') }}</a>
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
                                            @if(request()->get('menu'))
                                            <div class="card-footer">
                                                <h5 class="pull-right">
                                                    <span class="delete-action">
                                                        <a
                                                            class="btn btn-danger"
                                                            onclick="deletemenu()"
                                                            href="javascript:void(9)"
                                                        >{{ trans('wmenu::menu.deleteMenu') }}</a>
                                                    </span>
                                                </h5>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
    @include('wmenu::scripts')
@endsection
