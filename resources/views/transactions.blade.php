<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transactions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <table class="table is-striped">
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
                            <div class="column is-narrow">
                                {{ $transactions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
