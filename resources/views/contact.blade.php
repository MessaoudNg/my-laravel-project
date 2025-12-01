@extends('layouts.app')

@section('content')
<div class="contact-container" style="max-width: 600px; margin: 40px auto; padding: 25px; background: #fff; border-radius: 12px; box-shadow: 0 4px 18px rgba(0,0,0,0.1);">
    
    <h2 style="text-align: center; margin-bottom: 20px; color:#222;">📩 اتصل بنا</h2>

    @if(session('success'))
        <div style="padding: 15px; background:#d4edda; color:#155724; border-radius: 6px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf
        
        <label>الاسم الكامل</label>
        <input type="text" name="name" required style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;">

        <label>البريد الإلكتروني</label>
        <input type="email" name="email" required style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;">

        <label>الموضوع</label>
        <input type="text" name="subject" required style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;">

        <label>رسالتك</label>
        <textarea name="message" rows="5" required style="width:100%; padding:10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc;"></textarea>

        <button type="submit" style="width:100%; padding:12px; background:#28a745; border:none; color:#fff; font-size:16px; border-radius:6px; cursor:pointer;">
            إرسال الرسالة
        </button>
    </form>
</div>
@endsection
