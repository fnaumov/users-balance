@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="container">
                    <div>
                        <form method="GET" action="{{ route('transactions') }}" class="row g-3">
                            <div class="col-auto">
                                <label for="description_search">Поиск по описанию</label>
                                <input type="text" name="description_search" id="description_search">
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3">Найти</button>
                            </div>
                        </form>
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
                        <div class="columns">
                            <div class="d-flex">
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
