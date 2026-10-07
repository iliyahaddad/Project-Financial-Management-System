<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: 'DejaVu Sans', sans-serif; direction: rtl; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #999; padding: 4px; text-align: center; }
    th { background: #1e293b; color: #fff; }
  </style>
</head>
<body>
  <h3>{{ $title }}</h3>
  <table>
    <thead><tr>@foreach($headings as $h)<th>{{ $h }}</th>@endforeach</tr></thead>
    <tbody>
      @foreach($rows as $row)<tr>@foreach($row as $cell)<td>{{ $cell }}</td>@endforeach</tr>@endforeach
    </tbody>
  </table>
</body>
</html>
