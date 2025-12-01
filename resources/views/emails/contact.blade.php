<h2>لديك رسالة جديدة من صفحة اتصل بنا</h2>

<p><strong>الاسم:</strong> {{ $data['name'] }}</p>
<p><strong>البريد:</strong> {{ $data['email'] }}</p>
<p><strong>الموضوع:</strong> {{ $data['subject'] }}</p>

<p><strong>الرسالة:</strong></p>
<p>{{ $data['message'] }}</p>

<div style="text-align:center; margin-top:20px;">
    <a href="https://wa.me/213666877686"
       style="background:#25d366; padding:12px 20px; color:#fff; border-radius:8px; text-decoration:none; font-size:16px;">
        تحدث معنا عبر واتساب 📞
    </a>
</div>
<h3 style="margin-top:30px;">📍 موقعنا على الخريطة</h3>

<div style="margin-top:15px;">
    <iframe 
        src="https://www.google.com/maps/embed?pb=https://maps.app.goo.gl/RxtbAqQbg81K8TQz5"
        width="100%" height="300" style="border:0; border-radius:10px;" allowfullscreen loading="lazy">
    </iframe>
</div>

