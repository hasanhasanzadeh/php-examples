<?php
$users=[
    [
        'email'=>'samih@gmail.com',
        'password'=>'123456',
        'jwt'=>''
    ],
    [
        'email'=>'payman@gmail.com',
        'password'=>'12345678',
        'jwt'=>''
    ],
    [
        'email'=>'ali@gmail.com',
        'password'=>'112233',
        'jwt'=>''
    ],
];

function responseToJson($array)
{
    return json_encode($array, JSON_UNESCAPED_UNICODE);
}

if ($_SERVER['REQUEST_METHOD']==='POST'){
    echo Login($_POST['email'],$_POST['password']);
}else{
    echo getProfile($_REQUEST['jwt']);
}

function encryptJwt($string): string
{
   return base64_encode($string);
}

function decryptJwt($string): string
{
   return base64_decode($string);
}

function Login($email,$password){
    global $users;
    foreach($users as $user){
        if($user['email']==$email && $user['password']==$password){
            $user['jwt']=encryptJwt($user['email']);
          return responseToJson([
                'msg'=>'Login success',
                'data'=>$user,
                'status'=>200,
            ]);
        }
    }
    return responseToJson([
        'msg'=>'Email or Password invalid',
        'data'=>null,
        'status'=>4022,
    ]);
}

function getProfile($jwt)
{
    global $users;

    foreach($users as $user){
        if($user['email']==decryptJwt($jwt)){
            return responseToJson( [
                'msg'=>'get profile success',
                'data'=>$user,
                'status'=>200,
            ]);
        }
    }

    return responseToJson( [
      'msg'=>'Unauthorized',
      'data'=>null,
      'status'=>401,
    ]);
}
