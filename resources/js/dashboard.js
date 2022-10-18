$(document).ready(function(){
    getTransactions();

    function getTransactions(){
        $.ajax({
            type: "GET",
            url: "dashboard/refresh?last_transaction_id=" + $('div#last-transactions').find('td[data-id]:first').data('id'),
            async: true,
            complete: function (response) {
                updateTransactionsTable($.parseJSON(response.responseText));

                setTimeout(function () {
                    getTransactions();
                }, 10000);
            }
        });
    }

    function updateTransactionsTable(json){
        let transactions = json.transactions.reverse();

        if (transactions.length === 0) {
            return;
        }

        for (let i = 0; i < transactions.length; ++i) {
            let lastTr = $('div#last-transactions').find('tr:last').prependTo('tbody');

            lastTr.find('td:eq(0)').attr('data-id', transactions[i]['id']);
            lastTr.find('td:eq(0)').html(transactions[i]['id']);
            lastTr.find('td:eq(1)').html(transactions[i]['amount']);
            lastTr.find('td:eq(2)').html(transactions[i]['currency']);
            lastTr.find('td:eq(3)').html(transactions[i]['description']);
            lastTr.find('td:eq(4)').html(transactions[i]['created_at']);
        }

        let balances = json.balances;

        $('div#user-balance').find('p[data-currency]').each(function() {
            let currency = $(this).data('currency');

            $(this).find('span').html(balances[currency].balance);
        });
    }
});
