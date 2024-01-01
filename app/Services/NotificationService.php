<?php
namespace App\Services;
use App\Models\UserNotification;
use App\Models\User;
use Storage;

class NotificationService
{
    protected $NotificationModel;
	protected $UserModel;
    public function __construct()
    {
        $this->NotificationModel = new UserNotification();
    	$this->UserModel = new User();
    }

    public function getNotifications($data = [])
    {
        return $this->NotificationModel->where('user_id',$data['user_id'])->where('is_sent',1)->orderBy('id','DESC')->get();
    }
    public function deleteAccount($data = [])
    {
        $user = $this->UserModel->find($data['user_id']);
        if($user)
        {
            $user->delete();
            return $user;
        }
        return null;
    }
    
}
