@extends('core::admin.'.$theme_cms->value.'.templates.parent')

@section('title_dashboard', ' Account')

@section('page_level_css')
    {{Html::style(module_asset_url('core:assets/metronic-v5/pages/css/profile.min.css'))}}
    {{Html::style(module_asset_url('core:assets/metronic-v5/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'))}}
@endsection

@section('breadcrumb')
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="#" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">-</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Home</span>
                </a>
            </li>
            <li class="m-nav__separator">-</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Profile</span>
                </a>
            </li>
        </ul>
@endsection

@section('content')

{{-- Row --}}

    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="m-portlet m-portlet--full-height  ">
                <div class="m-portlet__body">
                    <div class="m-card-profile">
                        <div class="m-card-profile__title m--hide">
                            Your Profile
                        </div>
                        <div class="m-card-profile__pic">
                            <div class="m-card-profile__pic-wrapper">
                                @if(empty($account->profile_image_url))
                                    <img src="{{module_asset_url('core:assets/images/atomix_user31.png')}}" alt="" />
                                @else
                                    <img src="{{Storage::url($account->profile_image_url)}}" alt=""> 
                                @endif
                            </div>
                        </div>
                        <div class="m-card-profile__details">
                            <span class="m-card-profile__name">{{Auth::user()->name}}</span>
                            <a href="" class="m-card-profile__email m-link">{{Auth::user()->email}}</a>
                        </div>
                    </div>
                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__section m--hide">
                            <span class="m-nav__section-text">Section</span>
                        </li>
                        <li class="m-nav__item">
                            <a href="javascript:void(0)" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                <span class="m-nav__link-title">
                                    <span class="m-nav__link-wrap">
                                        <span class="m-nav__link-text">My Profile</span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="javascript:void(0)" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                <span class="m-nav__link-text">Support</span>
                            </a>
                        </li>
                    </ul>
                    <div class="m-portlet__body-separator"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Personal Info
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
                                    Avatar
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_3" role="tab">
                                    Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        <form class="m-form m-form--fit m-form--label-align-right" action="{{action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@personal')}}" method="post">
                            <div class="m-portlet__body">
                                <div class="col-md-5 offset-md-2">
                                    @if (!empty(session('global_message')))
                                        <div class="alert {{session('global_message')['status'] == 200 ? 'alert-info' : 'alert-warning' }} alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            {{session('global_message')['message']}}
                                        </div>
                                    @endif
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Email</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="email" value="{{!empty(Auth::user()->email) ? Auth::user()->email : ''}}" name="email">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Full Name</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="text" name="name" value="{{!empty(Auth::user()->name) ? Auth::user()->name : old('name')}}" pattern="[0-9A-Za-z.\s]+" title="Enter Correct's Name">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Gender</label>
                                    <div class="col-7">
                                        <div class="m-radio-inline">
                                            <label class="m-radio">
                                                <input type="radio" name="gender" value="male" {{!empty($account) && $account->gender == 'male' ? 'checked' : ''}}> Male
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                <input type="radio" name="gender" value="female" {{!empty($account) && $account->gender == 'female' ? 'checked' : ''}}> Female
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Birthday</label>
                                    <div class="col-7">
                                        <input class="form-control m-inputd date-picker" type="text" value="{{!empty($account->birthday) ? $account->birthday : old('birthday')}}" name="birthday" data-date-format="yyyy-mm-dd" data-date-end-date="-10y" data-date-start-date="-100y"  data-date-orientation="left bottom" placeholder="yyyy-mm-dd">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Phone No.</label>
                                    <div class="col-7">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    +62
                                                </span>
                                            </div>
                                            <input class="form-control m-input phone" type="text" value="{{!empty($account->phone_number) ? $account->phone_number : old('phone_number')}}" name="phone_number" placeholder="82299xxxx">
                                        </div>
                                    </div>
                                </div>
                                 <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Address</label>
                                    <div class="col-7">
                                        <textarea type="text" class="form-control m-input autosize" name="address" id="m_autosize_2">{{!empty($account->address) ? $account->address : old('address')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-7">
                                            <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save changes</button>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane " id="m_user_profile_tab_2">
                        <form class="m-form m-form--fit m-form--label-align-right" action="{{action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@avatar')}}" method="post" enctype="multipart/form-data">
                            <div class="m-portlet__body">
                                <div class="col-md-5 offset-md-2">
                                    @if (!empty(session('global_message')))
                                        <div class="alert {{session('global_message')['status'] == 200 ? 'alert-info' : 'alert-warning' }} alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            {{session('global_message')['message']}}
                                        </div>
                                    @endif
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-7 offset-1">
                                    <p> Change Your Photo's Profile</p>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-7 offset-1">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                @if(!empty($account) && $account->profile_image_url != null)
                                                    <img src="{{Storage::url($account->profile_image_url)}}" alt=""> 
                                                @else
                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> 
                                                @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn btn-file btn-accent m-btn m-btn--air m-btn--custom">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" name="profile_image_url"> </span>
                                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-7">
                                            <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save changes</button>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane " id="m_user_profile_tab_3">
                        <form class="m-form m-form--fit m-form--label-align-right" action="{{action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@password')}}" method="post">
                            <div class="m-portlet__body">
                                <div class="col-md-5 offset-md-2">
                                    @if (!empty(session('global_message')))
                                        <div class="alert {{session('global_message')['status'] == 200 ? 'alert-info' : 'alert-warning' }} alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            {{session('global_message')['message']}}
                                        </div>
                                    @endif
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                @if(Auth::user()->password != '')
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-3 col-form-label">Old Password</label>
                                        <div class="col-7">
                                            <input class="form-control m-input" type="password" placeholder="Min Length 8 Character" name="old_password">
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">New Password</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="password" placeholder="Min Length 8 Character" name="password">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">Re-type New Password</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="password" placeholder="Min Length 8 Character" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-7">
                                            <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save changes</button>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- End of Row --}}

@endsection

@section('page_level_js')
    {{Html::script(module_asset_url('core:assets/metronic-v5/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'))}}
@endsection