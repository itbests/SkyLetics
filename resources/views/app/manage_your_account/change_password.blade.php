@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1>Change Password</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ asset('path/to/profile/image.jpg') }}"
                             alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                    <p class="text-muted text-center">{{ Auth::user()->email }}</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#change-password" data-toggle="tab">Change Password</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="change-password">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="oldPassword" class="col-sm-2 col-form-label">{{ @trans('change_password.old_password') }}</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text bg-primary text-white"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="oldPassword" placeholder="{{ @trans('change_password.old_password_placeholder') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="newPassword" class="col-sm-2 col-form-label">{{ @trans('change_password.new_password') }}</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text bg-success text-white"><i class="fas fa-key"></i></span>
                                            <input type="password" class="form-control" id="newPassword" placeholder="{{ @trans('change_password.new_password_placeholder') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="confirmPassword" class="col-sm-2 col-form-label">{{ @trans('change_password.confirm_password') }}</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text bg-warning text-white"><i class="fas fa-lock"></i></span>
                                            <input type="password" class="form-control" id="confirmPassword" placeholder="{{ @trans('change_password.confirm_password_placeholder') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="captcha" class="col-sm-2 col-form-label">{{ @trans('change_password.captcha') }}</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text bg-danger text-white"><i class="fas fa-shield-alt"></i></span>
                                            <input type="text" class="form-control" id="captcha" placeholder="{{ @trans('change_password.captcha_placeholder') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <div class="text-center mb-3">
                                            {!! captcha_img('inverse') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary btn-sm px-4 mr-2">
                                            <i class="fas fa-check"></i> {{ @trans('change_password.button_change_password') }}
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm px-4">
                                            <i class="fas fa-times"></i> {{ @trans('change_password.button_cancel') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
