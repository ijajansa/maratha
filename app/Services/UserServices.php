<?php
namespace App\Services;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\UserDocument;
use Hash;
use Storage;

class UserServices
{
    protected $UserModel;
    protected $UserOTPModel;
    protected $UserDocumentModel;

    public function __construct()
    {
        $this->UserModel = new User();
        $this->UserOTPModel = new UserOtp();
        $this->UserDocumentModel = new UserDocument();
    }

    public function createUser(array $data = [])
    {
        if(isset($data['profile']))
        {
            $image = $data['profile'];
            $path = $data['profile']->store('profiles');
        }
        $record = $this->UserModel;
        $record->name = $data['name'];
        $record->email = $data['email'];
        $record->address = $data['address'];
        $record->contact_number = $data['contact_number'];
        $record->alternate_number = $data['alternate_number'];
        $record->device_id = $data['firebase_token'] ?? null;
        $record->role_id = 3;
        $record->otp = $data['otp'];
        $record->profile = $path ?? null;
        if(isset($data['password']))
        $record->password = Hash::make($data['password']);
        else
        $record->password = Hash::make('123456');
        $record->save();
        
        $document = $this->UserDocumentModel;
        $document->user_id = $record->id ?? 0;
        $document->save();
        
        return $record;

    }

    public function checkIsUserExists(array $user_data = []): ?object
    {
        return $this->UserModel->where('email', $user_data['email'])->first();
    }
    
    public function checkIsUserExistsMobile(array $user_data = []): ?object
    {
        return $this->UserModel->where('contact_number', $user_data['contact_number'])->first();
    }

    /**
     * Check user exist by contact_number & active
     *
     * @param array $user_data
     * @return object|null
     */
    public function checkIsUserActive(array $user_data = []): ?object
    {
        $record= $this->UserModel->where(
            [
                'email' => $user_data['email'],
                'is_active' => 1
            ]
        )->first();

        return $record;
    }

    /**
     * Insert OTP function
     *
     * @param array $user_data
     * @return object|null
     */
    public function insertOTP(array $user_data): ?object
    {
        $record= $this->UserModel->where(
            [
                'contact_number' => $user_data['contact_number'],
                'is_active' => 1
            ]
        )->first();
        if($record)
        {
            $record->otp = $user_data['otp'];
            $record->device_id = $user_data['firebase_token'];
            $record->save();
        }
        return $this->UserOTPModel->create($user_data);
    }

    public function update(int $id = 0, array $data = []) 
    {
        $user = $this->UserModel->where('id',$id)->first();
        if(isset($data['firebase_token']))
        {
            $check_user = $this->UserModel->where('id', '!=', $id)->where('device_id', $data['firebase_token'])->get();
            foreach ($check_user as $key => $value) 
            {
                $value->device_id = null;
                $value->save();
            }
        }

        if ($user) {
            $response = $this->UserModel->where('id', $id)->first();

            if ($response) {
                $response->otp = $data['otp'];
                $response->device_id = $data['firebase_token'] ?? null;
                $response->save();
                return [
                    'status' => 'success',
                    'message' => 'User details updated successfully'
                ];
            }
        }

        return [
            'status' => 'error',
            'message' => 'Invalid request'
        ];
    }

    public function sendOTP(array $user_data)
    {
        $otp = rand("1111","9999");
        //$otp = 1234;
        $record = $this->UserModel->where(
            [
                'contact_number' => $user_data['contact_number']
            ]
        )
        ->first();
        if($record)
        {
            $record->otp = $otp;
            $record->save();
        
        $this->OTP($user_data['contact_number'],$otp);
        return $otp;
        }
        return null;
        
    }
    
    public function OTP($contact_number,$otp)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://control.msg91.com/api/v5/otp?template_id=64f36a3cd6fc0568764484b3&mobile=91'.$contact_number.'&otp='.$otp.'&unicode=1&authkey=404975ADKNeF6q4btb64f36c23P1',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=c66smipop8l90koucmc3hlhbc5'
        ),
      ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    public function updateProfile(array $user_data=[])
    {
        $check = $this->UserModel
        ->where('id', '!=', $user_data['user_id'])
        ->where('contact_number', $user_data['contact_number'])->first();
        if($check)
        {
            return response()->json([
                'status' => false,
                'message' => 'Contact number already taken by another user',
            ]);
        }
        else
        {
            $check_profile = $this->UserModel->where('id', $user_data['user_id'])->first();
            if(isset($user_data['profile']))
            {
                $profile = $user_data['profile']->store('profile_images');
                $check_profile->profile = $profile;
            }
            $check_profile->name = $user_data['name'];
            $check_profile->address = $user_data['address'];
            $check_profile->contact_number = $user_data['contact_number'];
            $check_profile->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'profile_details' => $check_profile
                ]
            ]);
        }
    }
    
    public function getProfile($user_id)
    {
        return $this->UserModel->leftJoin('user_documents','user_documents.user_id','users.id')
        ->where('users.id',$user_id)
        ->select('users.*','user_documents.is_adhaar_front_verified','user_documents.adhaar_front_image','user_documents.is_adhaar_back_verified','user_documents.adhaar_back_image','user_documents.is_license_verified','user_documents.driving_license_image')
        ->first();
    }
    
    public function uploadDocument($data=[])
    {
        if(isset($data['adhaar_front_image']))
        {
            $path = $data['adhaar_front_image']->store('document_images');
        }
        if(isset($data['adhaar_back_image']))
        {
            $path1 = $data['adhaar_back_image']->store('document_images');
        }
        if(isset($data['driving_license_image']))
        {
            $path2 = $data['driving_license_image']->store('document_images');
        }
        $record = $this->UserDocumentModel->where('user_id',$data['user_id'])->first();
        if(!$record)
        {
            $record = $this->UserDocumentModel;
            $record->user_id = $data['user_id'] ?? 0;
        }

        if(isset($data['adhaar_front_image']))
        {
            $record->adhaar_front_image = $path ?? null;
            $record->is_adhaar_front_verified = 1;
        }
        if(isset($data['adhaar_back_image']))
        {
            $record->adhaar_back_image = $path1 ?? null;
            $record->is_adhaar_back_verified = 1;
        }
        if(isset($data['driving_license_image']))
        {
            $record->driving_license_image = $path2 ?? null;
            $record->is_license_verified = 1;
        }
        $record->save();   
        return $record;
    }
    
    public function changePassword($data)
    {
        $user = $this->UserModel->where('id',$data['user_id'])->first();
        if($user)
        {
            $user->password = Hash::make($data['password']);
            $user->save();
            return $user;
        }
        return null;
    }
    
    public function forgotPassword($data)
    {
        $user = $this->UserModel->where('contact_number',$data['email'])->orWhere('email',$data['email'])->first();
        if($user)
        {
            $user->password = Hash::make($data['password']);
            $user->save();
            return $user;
        }
        
        return null;
    }
    
    public function updateToken($data)
    {
        $user = $this->UserModel->find($data['user_id']);
        if($user)
        {
            $user->firebase_token = $data['firebase_token'];
            $user->save();
            return $user;
        }
        
        return null;
    }
}
