<table>
    <thead>
        <tr>
            <td>date</td>
            <td>expense name</td>
            <td>amount</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($expenses as $expense)
            <tr>
                <td>{{ \Carbon\Carbon::createFromDate($expense->created_at)->format('Y-m-d') }}</td>
                <td>{{ $expense->name }}</td>
                <td>{{ $expense->price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
