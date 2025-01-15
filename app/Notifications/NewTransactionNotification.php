<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Transactions;

class NewTransactionNotification extends Notification
{
    // use Queueable;

    // protected $transaction;

    // public function __construct(Transactions $transaction)
    // {
    //     $this->transaction = $transaction;
    // }

    // public function via($notifiable)
    // {
    //     return ['mail', 'database', 'broadcast'];
    // }

    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->line('Ada transaksi baru yang dibuat oleh customer.')
    //         ->action('Lihat Transaksi', url('/admin/transactions'))
    //         ->line('Terima kasih telah menggunakan aplikasi kami!');
    // }

    // public function toArray($notifiable)
    // {
    //     return [
    //         'transaction_id' => $this->transaction->id,
    //         'message' => 'Ada transaksi baru yang dibuat oleh customer.',
    //     ];
    // }

    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'transaction_id' => $this->transaction->id,
    //         'message' => 'Ada transaksi baru yang dibuat oleh customer.',
    //     ]);
    // }
    use Queueable;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'message' => 'Transaksi baru telah dibuat.',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'transaction_id' => $this->transaction->id,
            'message' => 'Transaksi baru telah dibuat.',
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'message' => 'Transaksi baru telah dibuat.',
        ];
    }
}


