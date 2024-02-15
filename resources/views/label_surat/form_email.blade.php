<html>

<head>
<title>{{$title}}</title>
</head>

<body>
    <br><br><b>Gunakan email dibawah ini untuk mengirimkan email masal anda.</b><br><br><textarea name=""
        style="width: 100%; height: 300px;">{{$email}}</textarea><br><br><br>Detail
    :<br>
    <table border="1" cellpadding="4" cellspacing="0">
        <thead class="bg-secondary">
            <tr>
                <th>No</th>
                <th>Organisasi/ Unit</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>{!! $table !!}</tbody>
    </table>
</body>

</html>