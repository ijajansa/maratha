<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\User;

class NotificationController extends Controller
{
	public function getAddNotification()
	{
		$users = User::where('role_id',3)->orderBy('name','ASC')->where('is_active',1)->get();
		return view('notifications.add',compact('users'));
	}
	public function addNotification(Request $request)
	{
		$request->validate([
			'title' => 'required|string',
			'description' => 'required',
			'users' => 'required',
			'image' => 'nullable'
		]);
		if($request->users[0] == "all")
		{
			$users = User::where('role_id',3)->orderBy('name','ASC')->where('is_active',1)->pluck('id');
		}
		else
		{
			$users = User::where('role_id',3)->orderBy('name','ASC')->where('is_active',1)->whereIn('id',$request->users)->pluck('id');
		}
		foreach($users as $user)
		{
			$notification = new UserNotification();
			$notification->user_id = $user;
			$notification->title = $request->title;
			$notification->description = $request->description;
			if(isset($request->image))
			{
				$notification->image = $request->file('image')->store('notifications');
			}
			$notification->save();
		}

		return redirect()->back()->with('success','Notifications sent successfully');



	}
}
