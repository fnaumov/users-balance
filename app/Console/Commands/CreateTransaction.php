<?php

namespace App\Console\Commands;

use App\Dictionary\Currency;
use App\Dictionary\TransactionDirection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use PDOException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Throwable;

class CreateTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:create {email} {direction} {amount} {currency} {description?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for create transaction';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $direction = $this->argument('direction');
        $amount = (float) $this->argument('amount');
        $currency = $this->argument('currency');
        $description = htmlspecialchars($this->argument('description'));

        $user = User::firstWhere([
            'email' => $email,
        ]);

        if (!$user) {
            $this->error(sprintf('User with email `%s` not found', $email));

            return SymfonyCommand::FAILURE;
        }

        if (!in_array($direction, TransactionDirection::getList(), true)) {
            $this->error(sprintf('Direction must be equal one of [%s]', implode(', ', TransactionDirection::getList())));

            return SymfonyCommand::FAILURE;
        }

        if ($amount <= 0) {
            $this->error('Amount must be greater than zero');

            return SymfonyCommand::FAILURE;
        }

        if (!in_array($currency, Currency::getList(), true)) {
            $this->error(sprintf('Currency must be equal one of [%s]', implode(', ', Currency::getList())));

            return SymfonyCommand::FAILURE;
        }

        try {
            DB::beginTransaction();

            $this->createTransaction(
                $user,
                $direction,
                $amount,
                $currency,
                $description,
            );

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            $this->error(sprintf('Undefined exception: %s', $e->getMessage()));

            return SymfonyCommand::FAILURE;
        }

        $this->info('Transaction successfully completed');

        return SymfonyCommand::SUCCESS;
    }

    private function createTransaction(
        User $user,
        string $direction,
        float $amount,
        string $currency,
        ?string $description = null
    ) {
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'currency' => $currency,
            'direction' => $direction,
            'description' => $description ?: null,
        ]);

        $userBalance = UserBalance::firstWhere([
            'user_id' => $user->id,
            'currency' => $currency,
        ]);

        if (!$userBalance) {
            $userBalance = UserBalance::create([
                'user_id' => $user->id,
                'balance' => 0,
                'currency' => $currency,
            ]);
        }

        $this->changeBalance($direction, $userBalance, $amount);

        $transaction->save();
        $userBalance->save();
    }

    private function changeBalance(string $direction, UserBalance $userBalance, float $amount)
    {
        if ($direction === TransactionDirection::IN) {
            $userBalance->balance += $amount;

            return $userBalance;
        }

        if ($direction === TransactionDirection::OUT) {
            $this->checkBalance($userBalance->balance, $amount);

            $userBalance->balance -= $amount;

            return $userBalance;
        }

        throw new InvalidArgumentException('Unexpected direction');
    }

    private function checkBalance(float $balance, float $subAmount)
    {
        if ($balance < $subAmount) {
            throw new InvalidArgumentException('There are not enough funds on the user account');
        }
    }
}
