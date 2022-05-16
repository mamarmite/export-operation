<html>
<head>
    <title>Export PDF</title>
</head>
<body>
    <table>
        @isset($headers)
        <thead>
            <tr>
                    @foreach($headers as $index => $column)
                        <th>{{$column}}</th>
                    @endforeach

            </tr>
        </thead>
        @endisset
        @isset($entries)
        <tbody>
            @foreach($entries as $index => $entry)
                <tr>
                    @foreach($entry as $colname => $column)
                        <td>{{$column}}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        @endisset
    </table>
</body>
</html>