@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="container gy-5">
                    <div>
                        <p>Баланс:</p>

                        @foreach ($currencyList as $currency)
                            @if(isset($balancesKeyByCurrency[$currency]))
                                <p>{{ $balancesKeyByCurrency[$currency]->balance }} {{ $balancesKeyByCurrency[$currency]->currency }}</p>
                            @else
                                <p>0 {{ $currency }}</p>
                            @endif
                        @endforeach
                    </div>

                    <div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Сумма</th>
                                <th>Валюта</th>
                                <th>Описание</th>
                                <th>Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->id}}</td>
                                    <td>{{$transaction->amount}}</td>
                                    <td>{{$transaction->currency}}</td>
                                    <td>{{$transaction->description}}</td>
                                    <td>{{$transaction->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
