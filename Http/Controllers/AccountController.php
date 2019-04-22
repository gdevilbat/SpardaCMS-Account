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

class AccountController extends CoreController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $account = new Repository(new UserAccount_m);
        $this->data['account'] = $account->with('user')->buildQueryByAttributes(['user_id' => Auth::user()->id])->first();
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

        $user = User_m::find(Auth::user()['id']);
        $user->email = $request->input('email');
        $user->name = $request->input('name');

        if(!$user->save())
        {
            return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Update Email!'));
        }
        else
        {

            $account = UserAccount_m::find(Auth::user()['id']);
            if(empty($account))
                $account = new UserAccount_m;

            foreach ($data as $key => $value) 
            {
                $account->$key = $value;
            }
            $account->user_id = Auth::user()['id'];

            if($account->save())
            {
                return redirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))->with('global_message', array('status' => 200,'message' => 'Successfully Update Profile!'));
            }
            else
            {
                return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Update Profile!'));
            }
        }
    }

    public function avatar(Request $request)
    {
        if ($request->hasFile('profile_image_url')) 
        {
            $path = $request->profile_image_url->store('user_public/'.(string)Auth::user()->id, 'public');

            if ($request->file('profile_image_url')->isValid()) 
            {
                $account = UserAccount_m::where('user_id', Auth::user()->id)->first();
                $account->profile_image_url = $path;

                if($account->update())
                {
                    return redirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))->with('global_message', array('status' => 200,'message' => 'Successfully Update Avatar!'));
                    
                }
                else
                {
                    return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Update Avatar!'));
                }
            }
            else
            {
                return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Upload Image!'));
            }
        }
        else
        {
            return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Photo Not Found'));
        }
    }

    public function password(Request $request)
    {
        $this->validate($request, [
                'password' => 'required|min: 8|confirmed',
            ]);

        $user = User_m::find(Auth::user()->id);

        if($user->password != '')
        {
            $this->validate($request, [
                'old_password' => 'required|min: 8',
            ]);

            if(!Hash::check($request->input('old_password'), $user->password))
            {
                return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Wrong Old Password'));
            }
        }


        $user->password = bcrypt($request->input('password'));

        if($user->update())
        {
            return redirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))->with('global_message', array('status' => 200,'message' => 'Successfully Change Password!'));
        }
        else
        {
            return redirect()->back()->with('global_message', array('status' => 400, 'message' => 'Failed To Change Password'));
        }
    }
}
