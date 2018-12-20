<?php
// namespace App\Http\Middleware;

// use Closure;
// use App\Driver;
// use Illuminate\Contracts\Auth\Factory as Auth;

// class Authenticate
// {
//     /**
//      * The authentication guard factory instance.
//      *
//      * @var \Illuminate\Contracts\Auth\Factory
//      */
//     protected $auth;

//     /**
//      * Create a new middleware instance.
//      *
//      * @param  \Illuminate\Contracts\Auth\Factory  $auth
//      * @return void
//      */
//     public function __construct(Auth $auth)
//     {
//         $this->auth = $auth;
//     }

//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure  $next
//      * @param  string|null  $guard
//      * @return mixed
//      */
//     public function handle($request, Closure $next, $guard = null)
//     {
//         if ($this->auth->guard($guard)->guest()) {
//             if ($request->has('api_token')) {
//                 try {
//                     $token = $request->input('api_token');
//                     $check_token = Driver::where('api_token', $token)->first();
//                     if ($check_token) {
//                         return json_encode([
//                             'status'=>false,
//                             'message'=>'Unauthorize',
//                           ], 401);
//                         // $res['status'] = false;
//                         // $res['message'] = 'Unauthorize';
//                         // return response($res, 401);
//                     }
//                 } catch (\Illuminate\Database\QueryException $ex) {

//                     return json_encode([
//                         'status'=>false,
//                         'message'=>$ex->getMessage(),
//                       ], 500);

//                     // $res['status'] = false;
//                     // $res['message'] = $ex->getMessage();
//                     // return response($res, 500);
//                 }
//             } else {

//                 return json_encode([
//                     'status'=>false,
//                     'message'=>'Please, Login!',
//                   ], 401);
//                 // $res['status'] = false;
//                 // $res['message'] = 'Login please!';
//                 // return response($res, 401);
//             }
//         }
//         return $next($request);
//     }
//}
