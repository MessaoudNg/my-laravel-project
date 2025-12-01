<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // عرض صفحة الاتصال (Frontend)
    public function index()
    {
        return view('contact'); // ضع اسم الصفحة التي تريد عرضها
    }

    // استقبال الرسالة من الفورم وإرسال البريد
    public function send(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // إرسال البريد
        \Mail::send('emails.contact', ['data' => $request->all()], function($message) use ($request) {
            $message->to('neghmouchsalah@gmail.com'); // ضع بريدك هنا
            $message->subject($request->subject);
        });

        // إرسال رسالة للعميل
\Mail::send('emails.reply', ['data' => $request->all()], function($message) use ($request) {
    $message->to($request->email); // بريد العميل
    $message->subject('شكراً على تواصلك معنا');
});

        return back()->with('success', 'تم إرسال رسالتك بنجاح!');
    }
}
