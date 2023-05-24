<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
</head>
<body>

    <form method="POST" action="{{route('parse')}}">
        @csrf
        <label for="">masukkan file xml</label>
        <input type="file" name="file_xml" id="file_xml">
        <br>
        <button type="submit">Submit</button>

    </form>

</body>
</html>
