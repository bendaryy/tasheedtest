<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

  
  {{-- {{ print_r($data) }} --}}
  <table border="1">
      <tr>
          <th>الفرع</th>
        </tr>
        @foreach ($data as $item)
      <tr>
          <td>
               <h4> {{ $item['invoice']['issuer']['address']['branchID'] }}</h4>
          </td>
      </tr>
      @endforeach
  </table>

</body>

</html>
