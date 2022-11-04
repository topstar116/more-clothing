<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\EmailActivation;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerify;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['completeRegister', 'redirectTo']);;
    }

    /**
     * 仮登録メール送信画面
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showEmailVerifyForm()
    {
        return view('auth.verify');
    }

    /**
     * 仮登録メール送信処理
     *
     * @param Request $request
     * @return string
     */
    public function emailVerify(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:email_activations'],
            // 'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $registered_user = User::findByEmail($request->email);
        if(!empty($registered_user)) {
            return redirect(route('email.verify'))->with('verify-failed', 'このメールアドレスは既に登録済みです。');
        }

        $email_verification = EmailActivation::build($request->email);
        $email_verification->save();

        // メール送信
        $email = new EmailVerify($email_verification);
        Mail::to($email_verification->email)->send($email);

        return redirect(route('email.verify'))->with('success-message', '仮メールの送信に成功しました。');
        // return view('auth.verify', ['hours' => EmailActivation::EXPIRATION_HOURS])->with('success-message', '仮メールの送信に成功しました。');
    }

    /**
     * メール送信完了画面
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function completeEmailSend()
    {
        return view('auth.email-verify-send', [
            'hours' => EmailActivation::EXPIRATION_HOURS
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRegistrationForm($token)
    {
        // 有効なtokenか確認する
        $email_verification = EmailActivation::findByToken($token);
        $registered_user = User::findByEmail($email_verification->email);

        if (empty($email_verification)) {
            // 該当トークンなし
            return redirect(route('email.verify'))->with('verify-failed', 'トークンが不正です。');
        } elseif (!empty($registered_user)) {
            // 登録済み
           return redirect(route('email.verify'))->with('verify-failed', 'このメールアドレスは既に登録済みです。');
        } elseif (!$email_verification->isExpiration()) {
            // 有効期限切れ
            return redirect(route('email.verify'))->with('verify-failed', 'リンクの有効期限が切れています。再度仮登録メールを送信してください。');
        }

        // ステータスをメール認証済みに変更する
        // $email_verification->mailVerify();
        $email_verification->update();

        // $sexes = User::getArraySexes();

        return view('auth.register', [
            'token' => $token,
            'email' => $email_verification->email,
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @param $token
     *
     * @return \Illuminate\Contracts\Foundation\Application|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request, $token)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all(), $token)));

        $this->guard()->login($user);

        // 登録完了後、email_activationsのデータが削除
        $email_verification = EmailActivation::findByToken($token);
        $email_verification->delete();

        if ($response = $this->registered($request, $user)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'last_name'     => ['required', 'string', 'max:255'],
            'first_name'     => ['required', 'string', 'max:255'],
            'last_name_kana'     => ['required', 'string', 'max:255'],
            'first_name_kana'     => ['required', 'string', 'max:255'],
            'postcode'      => ['required', 'string', 'max:7'],
            'phone_number'       => ['required', 'string', 'max:12'],
            'city'  => ['required', 'string', 'max:255'],
            'block'  => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'password'  => Hash::make($data['password']),
            'api_token' => Str::random(60),
            'email'     => $data['email'],
            'last_name'     => $data['last_name'],
            'first_name'     => $data['first_name'],
            'last_name_kana'     => $data['last_name_kana'],
            'first_name_kana'     => $data['first_name_kana'],
            'postcode'      => $data['postcode'],
            'phone_number'       => $data['phone_number'],
            'city'  => $data['city'],
            'block'  => $data['block'],
        ]);
    }
}