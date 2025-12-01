<h2>الرسائل الواردة</h2>

<table border="1" width="100%" cellpadding="8">
    <tr>
        <th>الاسم</th>
        <th>الإيميل</th>
        <th>الموضوع</th>
        <th>الرسالة</th>
    </tr>

    @foreach($messages as $msg)
    <tr>
        <td>{{ $msg->name }}</td>
        <td>{{ $msg->email }}</td>
        <td>{{ $msg->subject }}</td>
        <td>{{ $msg->message }}</td>
    </tr>
    @endforeach
</table>
