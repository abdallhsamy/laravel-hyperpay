<?php

namespace Abdallhsamy\LaravelHyperpay\Support;

use Illuminate\Support\Arr;

class TransactionBuilder
{
    /**
     * The model that is transacting.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $owner;

    /**
     * Create a new transaction builder instance.
     *
     * @param  mixed  $owner
     * @return void
     */
    public function __construct($owner = null)
    {
        $this->owner = $owner;
    }

    /**
     * Create and clean pending transaction for the given user.
     *
     * @param  array  $transactionData
     *
     * @return \Abdallhsamy\LaravelHyperpay\Models\Transaction
     */
    public function create(array $transactionData, $cleanOldTransactions = true)
    {
        if ($cleanOldTransactions) {
            $this->currentUserCleanOldPendingTransaction();
        }
    

        $transaction = $this->owner->transactions()->create([
            'id' => Arr::get($transactionData, 'merchantTransactionId'),
            config('hyperpay.foreign_key') => $this->owner->id,
            'checkout_id' => Arr::get($transactionData, 'id'),
            'status' => 'pending',
            'amount' => Arr::get($transactionData, 'amount'),
            'currency' => Arr::get($transactionData, 'currency'),
            'brand' => $this->getBrand($transactionData['entityId']),
            'data' => Arr::get($transactionData, 'result'),
            'trackable_data' => Arr::get($transactionData, 'trackable_data'),
        ]);

        return $transaction;
    }

    /**
     * Find the transaction in the database.
     *
     * @param string $id
     *
     * @return null|\Abdallhsamy\LaravelHyperpay\Models\Transaction
     */
    public function findByIdOrCheckoutId($id)
    {
        $transaction_model = config('hyperpay.transaction_model');
        $transaction = app($transaction_model)->whereId($id)->orWhere('checkout_id', $id)->first();

        return $transaction;
    }

    /**
     * Find the brand (VISA/MASTER OR MADA) based on the entityID
     * default = VISA/MASTER.
     *
     * @param string $entityId
     *
     * @return string
     */
    protected function getBrand($entityId)
    {
        if ($entityId == config('hyperpay.entityIdMada')) {
            return 'mada';
        }

        return 'default';
    }

    /**
     * Clean the given user pending transaction.
     *
     * @return void
     */
    protected function currentUserCleanOldPendingTransaction()
    {
        $transaction = $this->owner->transactions()->where('status', 'pending')->first();
        if ($transaction) {
            $transaction->delete();
        }
    }
}
