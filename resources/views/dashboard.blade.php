@extends('layouts.app')

@section('scripts')
    @parent
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="container gy-5">
                    <div id="user-balance">
                        <p>Баланс:</p>

                        @foreach ($currencyList as $currency)
                            <p data-currency="{{ $currency }}">
                                <span>{{ isset($balancesKeyByCurrency[$currency]) ? $balancesKeyByCurrency[$currency]->balance : 0 }}</span> {{ strtoupper($currency) }}
                            </p>
                        @endforeach
                    </div>

                    <div id="last-transactions">
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
                                    <td data-id="{{$transaction->id}}">{{$transaction->id}}</td>
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
