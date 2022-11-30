<template>
	<div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="m-portlet m-portlet--full-height">
                <div class="m-portlet__body">
                    <div class="m-card-profile">
                        <div class="m-card-profile__title m--hide">
                            Your Profile
                        </div>
                        <div class="m-card-profile__pic">
                            <div class="m-card-profile__pic-wrapper">
                                <img :src="avatar" alt="" />
                            </div>
                        </div>
                        <div class="m-card-profile__details">
                            <span class="m-card-profile__name">{{$parent.user.name}}</span>
                            <a href="" class="m-card-profile__email m-link">{{$parent.user.email}}</a>
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
                        <form class="m-form m-form--fit m-form--label-align-right" @submit.prevent="submitProfile($event)">
                            <div class="m-portlet__body">
                                <div class="col-md-5 offset-md-2" v-if="updated.status">
                                    <div class="alert alert-dismissible fade show" :class="{'alert-info': updated.code == 200, 'alert-danger': updated.code != 200}">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        {{updated.message}}
                                    </div>
                                </div>
                                <div class="col-md-5 offset-md-2" v-if="Object.keys(errors).length > 0">
                                    <div class="alert alert-danger" >
                                        <ul v-for="(error, key) in errors" :key="key">
                                            <li v-for="(item, index) in error" :key="index">{{item}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-2 col-form-label">Email :</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="email" name="email" v-model="$parent.user.email">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-2 col-form-label">Full Name :</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="text" name="name" pattern="[0-9A-Za-z.\s]+" title="Enter Correct's Name" v-model="$parent.user.name">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-2 col-form-label">Gender :</label>
                                    <div class="col-7">
                                        <div class="m-radio-inline">
                                            <label class="m-radio">
                                                <input type="radio" name="gender" value="male" v-model="$parent.user.account.gender"> Male
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                <input type="radio" name="gender" value="female"  v-model="$parent.user.account.gender"> Female
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-2 col-form-label">Birthday :</label>
                                    <div class="col-7">
                                        <input class="form-control m-inputd date-picker" type="text" name="birthday" data-date-format="yyyy-mm-dd" data-date-end-date="-10y" data-date-start-date="-100y"  data-date-orientation="left bottom" placeholder="yyyy-mm-dd" v-model="$parent.user.account.birthday">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-2 col-form-label">Phone No. :</label>
                                    <div class="col-7">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    +62
                                                </span>
                                            </div>
                                            <input class="form-control m-input phone" type="text" name="phone_number" placeholder="82299xxxx" v-model="$parent.user.account.phone_number">
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-2 col-form-label">Address :</label>
                                    <div class="col-7">
                                        <textarea type="text" class="form-control m-input autosize" name="address" id="m_autosize_2" v-model="$parent.user.account.address"></textarea>
                                    </div>
                                </div>
                            </div>
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
                        <form class="m-form m-form--fit m-form--label-align-right" @submit.prevent="submitAvatar($event)">
                            <div class="m-portlet__body">
                                <div class="col-md-5 offset-md-2" v-if="updated.status">
                                    <div class="alert alert-dismissible fade show" :class="{'alert-info': updated.code == 200, 'alert-danger': updated.code != 200}">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        {{updated.message}}
                                    </div>
                                </div>
                                <div class="col-md-5 offset-md-2" v-if="Object.keys(errors).length > 0">
                                    <div class="alert alert-danger" >
                                        <ul v-for="(error, key) in errors" :key="key">
                                            <li v-for="(item, index) in error" :key="index">{{item}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-7 offset-1">
                                    <p> Change Your Photo's Profile</p>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-7 offset-1">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img :src="avatar" alt=""> 
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div class="d-flex justify-content-center">
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
                        <form class="m-form m-form--fit m-form--label-align-right" @submit.prevent="submitPassword($event)">
                            <div class="m-portlet__body">
                                <div class="col-md-5 offset-md-2" v-if="updated.status">
                                    <div class="alert alert-dismissible fade show" :class="{'alert-info': updated.code == 200, 'alert-danger': updated.code != 200}">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        {{updated.message}}
                                    </div>
                                </div>
                                <div class="col-md-5 offset-md-2" v-if="Object.keys(errors).length > 0">
                                    <div class="alert alert-danger" >
                                        <ul v-for="(error, key) in errors" :key="key">
                                            <li v-for="(item, index) in error" :key="index">{{item}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-4 col-form-label">Old Password :</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="password" placeholder="Min Length 8 Character" name="old_password">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-4 col-form-label">New Password :</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="password" placeholder="Min Length 8 Character" name="password">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row align-items-center">
                                    <label for="example-text-input" class="col-4 col-form-label">Re-type New Password :</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" type="password" placeholder="Min Length 8 Character" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
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
        <loading
                :is-full-page="true"
                :active.sync="loading"/>
    </div>
</template>
<script>
    import $ from 'jquery'
    import Loading from 'vue-loading-overlay'

    import autosize from '^/Core/assets/js/autosize.min.js'

    export default {
        components: {
            Loading,
        },
        metaInfo(){
			return {
				script: [
					{
						skip: !this.$parent.vendor_loaded, 
						type: 'text/javascript', 
						src: "/metronic-v5/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js", 
						defer:true, 
						body: true
					},
                    {
                        skip: !this.$parent.vendor_loaded,
                        type: 'text/javascript', 
						src: "/metronic-v5/app/js/callback.js", 
						defer:true, 
						body: true,
                        callback: () => (this.updateScript())
                    }
				],
			}
		},
        data(){
            return{
                loading: false,
                updated: {
                    status: false,
                    code: 0,
                    message: ''
                },
                errors: {}
            }
        },
        created() {
          this.$parent.$data.breadcumb = `<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
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
                                            </ul>`;
        },
        mounted(){
            this.$nextTick(() => {
                autosize($(".autosize"));

                $(".phone").keyup(function(event) {
                    var phone = this.value;
                    for(var i = 0; i < phone.length; i++){
                        var valid_number;

                        if(phone.charAt(0) == '0')
                        {
                            valid_number = window.setCharAt(phone, 0, '');
                            $(this).val(valid_number);
                        }

                        if(!phone.charAt(i).match(/[0-9]/))
                        {
                            valid_number = window.setCharAt(phone, i, '');
                            $(this).val(valid_number);
                        }
                    }
                });

                $(".phone").keydown(function(event) {
                    var number = [8, 37, 39, 48, 49, 50, 51, 52 , 53, 54, 55, 56, 57];
                    var value  = $.inArray(event.keyCode, number);
                    if(value !== -1)
                    {
                        if(this.value.length === 0)
                        {
                            if(event.keyCode === 48)
                                return false;
                        }
                        return true;
                    }

                    return false;
                });
            });
        },
        computed: {
            avatar(){
                if(this.$parent.user.account.avatar != undefined)
                    return this.$parent.user.account.avatar;

                return '/modules/Core/assets/images/atomix_user31.png';
            }
        },
        methods: {
            submitProfile(e){
                const formData = new FormData(e.target);
                formData.append('_method', 'PUT');

                const self = this;

                self.loading = true;
                axios({
                    method: "post",
                    url: "/control/account/update-profile",
                    data: formData,
                })
                .then(function (response) {
                    //handle success
                    self.updated = response.data;
                    window.scrollTo(0, 0);
                    self.loading = false;

                    setTimeout(() => {
                        self.$set(self.updated, 'status', false);
                    }, 2000);

                })
                .catch(function (error) {
                    //handle error
                    self.loading = false;
                    self.errors = error.response.data.errors
                });
            },
            submitAvatar(e){
                const formData = new FormData(e.target);
                formData.append('_method', 'PUT');

                const self = this;

                self.loading = true;
                axios({
                    method: "post",
                    url: "/control/account/update-avatar",
                    data: formData,
                })
                .then(function (response) {
                    //handle success
                    self.updated = response.data;
                    window.scrollTo(0, 0);
                    self.loading = false;

                    setTimeout(() => {
                        self.$set(self.updated, 'status', false);
                    }, 2000);

                    self.$parent.getUser();

                })
                .catch(function (error) {
                    //handle error
                    self.loading = false;
                    self.errors = error.response.data.errors
                });
            },
            submitPassword(e){
                const formData = new FormData(e.target);
                formData.append('_method', 'PUT');

                const self = this;

                self.loading = true;
                axios({
                    method: "post",
                    url: "/control/account/update-password",
                    data: formData,
                })
                .then(function (response) {
                    //handle success
                    self.updated = response.data;
                    window.scrollTo(0, 0);
                    self.loading = false;

                    setTimeout(() => {
                        self.$set(self.updated, 'status', false);
                    }, 2000);

                })
                .catch(function (error) {
                    //handle error
                    self.loading = false;
                    self.errors = error.response.data.errors
                });
            },
            updateScript(){
                window.$(".date-picker").datepicker();
                window.$("[name='birthday']").on('changeDate',function() {
                    // Create native event
                    const event = new Event('input', { bubbles: true });

                    // Dispatch the event on "native" element
                    this.dispatchEvent(event);
                });
            }
        },
    }
</script>
<style lang="scss" scoped>
    @import 'vue-loading-overlay/dist/vue-loading.css';
    @import '^/Core/assets/metronic-v5/pages/css/profile.min.css';
    @import '^/Core/assets/metronic-v5/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css';
</style>