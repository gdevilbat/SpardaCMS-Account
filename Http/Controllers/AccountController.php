<?php

namespace Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gdevilbat\SpardaCMS\Modules\Core\Http\Controllers\CoreController;
use Gdevilbat\SpardaCMS\Modules\Account\Entities\UserAccount as UserAccount_m;
use Gdevilbat\SpardaCMS\Modules\Core\Entities\User as User_m;
use Gdevilbat\SpardaCMS\Modules\Core\Repositories\Repository;

use Auth;
use Hash;
use Storage;

class AccountController extends CoreController
{
    public function __construct()
    {
        parent::__construct();
        $this->user_m = new User_m;
        $this->user_repository = new Repository(new User_m, resolve(\Gdevilbat\SpardaCMS\Modules\Role\Repositories\Contract\AuthenticationRepository::class));
        $this->user_account_m = new UserAccount_m;
        $this->user_account_repository = new Repository(new UserAccount_m, resolve(\Gdevilbat\SpardaCMS\Modules\Role\Repositories\Contract\AuthenticationRepository::class));
    }

    public function me()
    {
        $user = $this->user_repository->with('userAccount')->findOrFail(\Auth::id());

        if(empty($user->userAccount)){
            $user->account = [];
        }else{
            $user->account = $user->userAccount;
        }

        $user->makeHidden(['userAccount']);

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user,
                'permissions' => [
                    'create_user' => Auth::user()->can('create-user')
                ]
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->data['account'] = $this->user_account_repository->buildQueryByAttributes(['user_id' => Auth::user()->id])->with('user')->first();
        return view('account::admin.'.$this->data['theme_cms']->value.'.content.profile', $this->data);
    }

    public function personal(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'name' => 'required|regex:/^[a-zA-Z.\s]+$/',
            'gender' => 'required',
            'birthday' => 'required|date',
            'phone_number' => 'required',
            'address' => 'required'
        ]);

        $data = $request->except('_token', '_method', 'name', 'email');

        $user = $this->user_m->find(Auth::user()['id']);
        $user->email = $request->input('email');
        $user->name = $request->input('name');

        if(!$user->save())
        {
            if($request->ajax()){
                return response()->json([
                    'status' => true,
                    'message' => 'Failed To Update Email!',
                    'code' => 400
                ]);
            }else{
                return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Update Email!'));
            }
        }
        else
        {

            $account = $this->user_account_repository->find(Auth::user()['id']);
            if(empty($account))
                $account = new $this->user_account_m;

            foreach ($data as $key => $value) 
            {
                $account->$key = $value;
            }
            $account->user_id = Auth::user()['id'];

            if($account->save())
            {
                if($request->ajax()){
                    return response()->json([
                        'status' => true,
                        'message' => 'Successfully Update Profile!',
                        'code' => 200
                    ]);
                }else{
                    return redirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))->with('global_message', array('status' => 200,'message' => 'Successfully Update Profile!'));
                }
            }
            else
            {
                if($request->ajax()){
                    return response()->json([
                        'status' => true,
                        'message' => 'Failed To Update Profile!',
                        'code' => 400
                    ]);
                }else{
                    return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Update Profile!'));
                }
            }
        }
    }

    public function avatar(Request $request)
    {
        if ($request->hasFile('profile_image_url')) 
        {
            $path = $request->profile_image_url->store('user_public/'.(string)Auth::user()->id);

            if ($request->file('profile_image_url')->isValid()) 
            {
                try {
                    $account = UserAccount_m::where('user_id', Auth::user()->id)->firstOrFail();
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    if($request->ajax()){
                        return response()->json([
                            'status' => true,
                            'message' => 'Update Your Profile Before Upload Image!',
                            'code' => 400
                        ]);
                    }else{
                        return redirect()->back()->with('global_message', array('status' => 400,'message' => 'Update Your Profile Before Upload Image!'));
                    }
                }

                $tmp = $account->profile_image_url;
                $account->profile_image_url = $path;

                Storage::disk()->delete($tmp);

                if($account->update())
                {
                    if($request->ajax()){
                        return response()->json([
                            'status' => true,
                            'message' => 'Successfully Update Avatar!',
                            'code' => 200
                        ]);
                    }else{
                        return redirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))->with('global_message', array('status' => 200,'message' => 'Successfully Update Avatar!'));
                    }
                    
                }
                else
                {
                    if($request->ajax()){
                        return response()->json([
                            'status' => true,
                            'message' => 'Failed To Update Avatar!',
                            'code' => 400
                        ]);
                    }else{
                        return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Update Avatar!'));
                    }
                }
            }
            else
            {
                if($request->ajax()){
                    return response()->json([
                        'status' => true,
                        'message' => 'Failed To Upload Image!',
                        'code' => 400
                    ]);
                }else{
                    return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Upload Image!'));
                }
            }
        }
        else
        {
            if($request->ajax()){
                return response()->json([
                    'status' => true,
                    'message' => 'Photo Not Found',
                    'code' => 400
                ]);
            }else{
                return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Photo Not Found'));
            }
        }
    }

    public function password(Request $request)
    {
        $this->validate($request, [
                'password' => 'required|min: 8|confirmed',
            ]);

        $user = $this->user_m->find(Auth::user()->id);

        if($user->password != '')
        {
            $this->validate($request, [
                'old_password' => 'required|min: 8',
            ]);

            if(!Hash::check($request->input('old_password'), $user->password))
            {
                if($request->ajax()){
                    return response()->json([
                        'status' => true,
                        'message' => 'Wrong Old Password',
                        'code' => 400
                    ]);
                }else{
                    return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Wrong Old Password'));
                }
            }
        }


        $user->password = $request->input('password');

        if($user->update())
        {
            if($request->ajax()){
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Change Password!',
                    'code' => 200
                ]);
            }else{
                return redirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))->with('global_message', array('status' => 200,'message' => 'Successfully Change Password!'));
            }
        }
        else
        {
            if($request->ajax()){
                return response()->json([
                    'status' => true,
                    'message' => 'Failed To Change Password',
                    'code' => 400
                ]);
            }else{
                return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Change Password'));
            }
        }
    }
}
