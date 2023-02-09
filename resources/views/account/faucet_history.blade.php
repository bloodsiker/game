
@if($type == \App\Models\FaucetHistory::TYPE_F)
    <table id='faucet_history_table' class='table table-striped table-bordered'>
        <thead>
        <tr>
            <th>Дата</th>
            <th>Сума</th>
            <th>Монета</th>
        </tr>
        </thead>
        <tbody>
        @foreach($faucets as $faucet)
            <tr>
                <td>{{ $faucet->date->format('Y-m-d H:i:s') }}</td>
                <td>{{ $faucet->amount }}</td>
                <td>{{ $faucet->currency->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if($type == \App\Models\FaucetHistory::TYPE_O)
    <table id='faucet_history_table' class='table table-striped table-bordered'>
        <thead>
        <tr>
            <th>Дата</th>
            <th>Сума</th>
            <th>Монета</th>
            <th>Описание</th>
        </tr>
        </thead>
        <tbody>
        @foreach($faucets as $faucet)
            <tr>
                <td>{{ $faucet->date->format('Y-m-d H:i:s') }}</td>
                <td>{{ $faucet->amount }}</td>
                <td>{{ $faucet->currency->name }}</td>
                <td>{{ $faucet->description }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
