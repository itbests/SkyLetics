@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content')
    <div class="content-header">

        <div class="container-fluid">
            @include('app.partials.header-breadcrumb')
        </div>
        <!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @php
                        $dataGrid = [
                            'idTable' => 'profile',
                            'nameOption' => $infoMenu['tooltip'],
                            'cardTitle' => $infoMenu['display_name'],
                            'themeCard' => 'lightblue',
                            'headThemeTable' => 'default',
                            'langFileTraslate' => 'profile',
                            'dataTable' => $profile,
                            'columnOrder' => 0,
                            'flagNewRegister' => true,
                            'routeProcess' => 'profile',
                            'actionsButtons' => [
                                'visibleColumn' => true,
                                'flagEditButton' => true,
                                'flagShowButton' => true,
                                'flagDeleteButton' => false,
                            ],
                            'exportButtons' => [
                                'flagPageLength' => true,
                                'flagCopyExportButton' => false,
                                'flagPrintExportButton' => true,
                                'flagCSVExportButton' => true,
                                'flagExcelExportButton' => true,
                                'flagPDFExportButton' => true,
                                'flagColvisButton' => true,
                            ]
                        ];
                    @endphp

                    @include('app.components.datagrid')

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal form to show -->
    {{-- Themed --}}
    <x-adminlte-modal id="showModal" title="{{ @trans('profile.title_show_modal') }}" theme="info"
        icon="fas fa-sitemap" size='lg' v-centered static-backdrop scrollable>

        <div class="card card-default">
            <div class="card-body">

                <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12"><strong><i class="fas fa-building mr-1"></i> @lang('profile.name_')</strong>
                                <p class="text-muted" data-campo="name_"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-map-marker-alt mr-1"></i> @lang('profile.address')</strong>
                                <p class="text-muted" data-campo="address"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-map-pin mr-1"></i> @lang('profile.office_id')</strong>
                                <p class="text-muted" data-campo="office_id"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-phone-square-alt mr-1"></i> @lang('profile.phone1')</strong>
                                <p class="text-muted" data-campo="phone1"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-mobile-alt mr-1"></i> @lang('profile.phone2')</strong>
                                <p class="text-muted" data-campo="phone2"></p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12"><strong><i class="fas fa-envelope-open-text mr-1"></i> @lang('profile.email')</strong>
                                <p class="text-muted" data-campo="email"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-paper-plane mr-1"></i> @lang('profile.view_line_process')</strong>
                                <p class="text-muted" data-campo="view_line_process"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-calendar-check mr-1"></i> @lang('profile.autoassigned')</strong>
                                <p class="text-muted" data-campo="autoassigned"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-calendar-alt mr-1"></i> @lang('profile.register_date')</strong>
                                <p class="text-muted" data-campo="register_date"></p>
                            </div>
                            <div class="col-md-12"><strong><i class="fas fa-lock-open mr-1"></i> @lang('profile.status_id')</strong>
                                <p class="text-muted" data-campo="status_id"></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="info" label="Cerrar" data-dismiss="modal"/>
        </x-slot>
    </x-adminlte-modal>

    <!-- Modal form to edit -->
    {{-- Custom --}}
    <x-adminlte-modal id="editModal" title="{{ @trans('profile.title_edit_modal') }}" theme="info"
        icon="fas fa-bell" size='lg' v-centered static-backdrop scrollable>

        <div class="card card-default">
            <div class="card-body">

                <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12"><strong> @lang('profile.name_')</strong>
                                <x-adminlte-input name="iBasic" data-campo="name_" required/>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.address')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="address" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.office_id')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="office_id" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-red">
                                            <i class="fas fa-map-pin"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.phone1')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="phone1" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-purple">
                                            <i class="fas fa-phone-square-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.phone2')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="phone2">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-green">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12"><strong> @lang('profile.email')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="email" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-blue">
                                            <i class="fas fa-envelope-open-text"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.view_line_process')</strong>
                                @php
                                    $options = $utilServices->getListYesNot();
                                    $selected = [''];
                                @endphp
                                <x-adminlte-select name="optionsTest1" data-campo="view_line_process" required>
                                    <x-adminlte-options :options="$options" :selected="$selected" empty-option="{{ __('general.select_option') }}"/>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-secondary">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.autoassigned')</strong>
                                @php
                                    $options = $utilServices->getListYesNot();
                                    $selected = [''];
                                @endphp
                                <x-adminlte-select name="optionsTest1" data-campo="autoassigned" required>
                                    <x-adminlte-options :options="$options" :selected="$selected" empty-option="{{ __('general.select_option') }}"/>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-orange">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.register_date')</strong>
                                @php
                                $config = ['format' => 'YYYY-MM-DD'];
                                @endphp
                                <x-adminlte-input-date name="idDisabled" value="2020-10-04" :config="$config" disabled data-campo="register_date"/>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.status_id')</strong>
                                @php
                                    $options = $utilServices->getStatusList(1);
                                    $selected = [''];
                                @endphp
                                <x-adminlte-select name="optionsTest1" data-campo="status_id" required>
                                    <x-adminlte-options :options="$options" :selected="$selected" empty-option="{{ __('general.select_option') }}"/>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-teal">
                                            <i class="fas fa-lock-open"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="{{ __('general.update') }}"/>
            <x-adminlte-button theme="danger" label="{{ __('general.close') }}" data-dismiss="modal"/>
        </x-slot>
    </x-adminlte-modal>


    <!-- Modal form to register -->
    {{-- Custom --}}
    <x-adminlte-modal id="registerModal" title="{{ @trans('profile.title_register_modal') }}" theme="info"
        icon="fas fa-bell" size='lg' v-centered static-backdrop scrollable>

        <div class="card card-default">
            <div class="card-body">

                <div class="modal-body">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12"><strong> @lang('profile.name_')</strong>
                                <x-adminlte-input name="iBasic" data-campo="name_" required/>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.address')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="address" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-info">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.office_id')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="office_id" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-red">
                                            <i class="fas fa-map-pin"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.phone1')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="phone1" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-purple">
                                            <i class="fas fa-phone-square-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.phone2')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="phone2">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-green">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12"><strong> @lang('profile.email')</strong>
                                <x-adminlte-input name="iExtraAddress" data-campo="email" required>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-blue">
                                            <i class="fas fa-envelope-open-text"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.view_line_process')</strong>
                                @php
                                    $options = $utilServices->getListYesNot();
                                    $selected = [''];
                                @endphp
                                <x-adminlte-select name="optionsTest1" data-campo="view_line_process" required>
                                    <x-adminlte-options :options="$options" :selected="$selected" empty-option="{{ __('general.select_option') }}"/>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-secondary">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.autoassigned')</strong>
                                @php
                                    $options = $utilServices->getListYesNot();
                                    $selected = [''];
                                @endphp
                                <x-adminlte-select name="optionsTest1" data-campo="autoassigned" required>
                                    <x-adminlte-options :options="$options" :selected="$selected" empty-option="{{ __('general.select_option') }}"/>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-orange">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.register_date')</strong>
                                @php
                                $config = ['format' => 'YYYY-MM-DD'];
                                @endphp
                                <x-adminlte-input-date name="idDisabled" value="2020-10-04" :config="$config" data-campo="register_date"/>
                            </div>
                            <div class="col-md-12"><strong> @lang('profile.status_id')</strong>
                                @php
                                    $options = $utilServices->getStatusList(1);
                                    $selected = [''];
                                @endphp
                                <x-adminlte-select name="optionsTest1" data-campo="status_id" required>
                                    <x-adminlte-options :options="$options" :selected="$selected" empty-option="{{ __('general.select_option') }}"/>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text text-teal">
                                            <i class="fas fa-lock-open"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="{{ __('general.update') }}"/>
            <x-adminlte-button theme="danger" label="{{ __('general.close') }}" data-dismiss="modal"/>
        </x-slot>
    </x-adminlte-modal>

@endsection

@section('js')
    <script>
        // Función para cargar y mostrar la modal con datos (Show)
        function LoadAndShowModal(urlService) {
            $.ajax({
                type: 'GET',
                url: urlService,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function(response) {
                    $('.text-muted').each(function() {
                        var campo = $(this).data('campo');
                        $(this).text(response[0][campo]);
                    });
                    $('#showModal').modal('show');
                },
                error: function(error) {
                    // Manejo de errores
                    console.log(error);
                }
            });
        }

        $(document).on('click', '.show-modal', function() {
            var urlService = $(this).data().url;
            LoadAndShowModal(urlService);
        });
    </script>

    <script>
        // Función para cargar y mostrar la modal con datos (Edit)
        function LoadAndEditModal(urlService) {
            $.ajax({
                type: 'GET',
                url: urlService,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function(response) {
                    $('.form-control').each(function() {
                        var campo = $(this).data('campo');
                        var valor = response[campo];

                        // Verificar si el elemento es un campo de entrada o una lista desplegable
                        if ($(this).is('input, textarea')) {
                            $(this).val(valor);
                        } else if ($(this).is('select')) {
                            // Asumiendo que el valor corresponde a una de las opciones en la lista desplegable
                            $(this).val(valor);
                        }
                    });
                    $('#editModal').modal('show');
                },
                error: function(error) {
                    // Manejo de errores
                    console.log(error);
                }
            });
        }

        $(document).on('click', '.edit-modal', function() {
            var urlService = $(this).data().url;
            LoadAndEditModal(urlService);
        });
    </script>

    <script>
        $.fn.dataTable.ext.buttons.newRecord = {
            text: 'newRecord',
            action: function ( e, dt, node, config ) {
                $('#registerModal *').val('');
                $('#registerModal').modal('show');
            }
        };
    </script>
@endsection
