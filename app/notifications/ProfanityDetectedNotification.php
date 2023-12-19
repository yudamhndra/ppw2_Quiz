use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProfanityDetectedNotification extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Review baru mengandung kata-kata tidak sopan.')
            ->action('Lihat Moderasi', route('admin.moderateReviews'));
    }
}