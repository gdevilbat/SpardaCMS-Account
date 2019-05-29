<li class="m-menu__item  {{Route::current()->getName() == 'account' ? 'm-menu__item--active' : ''}}" aria-haspopup="true">
    <a href="{{action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index')}}" class="m-menu__link ">
        <i class="m-menu__link-icon flaticon-user-settings"></i>
        <span class="m-menu__link-title"> 
            <span class="m-menu__link-wrap"> 
                <span class="m-menu__link-text">
                    Account
                </span>
             </span>
         </span>
     </a>
</li>