<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>xlsupload</title>
</head>
<body>
  <form action="{{url('/xls/obj')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <p><input type="file" name="xlsfile" accept=".xls,.xlsx,.csv"></p>
    <p><input type="submit"></p>
  </form>
</body>
</html>
