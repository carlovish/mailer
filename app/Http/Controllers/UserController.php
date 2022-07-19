<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Email;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('admin.index');
            }


            $this->sendEmails($user);

            return Inertia::render('User/Index', [
                "emails" => Email::whereBelongsTo($user)->paginate(10)
            ]);
        }
    }

    protected function sendEmails($user)
    {
        $emails = Email::whereBelongsTo($user)
            ->where('status', 'not-sent')
            ->get();

        foreach ($emails as $email) {
            SendEmail::dispatch($email->addresee, $email->subject, $email->content);
            $email->status = 'sent';
            $email->save();
        }
    }
}
