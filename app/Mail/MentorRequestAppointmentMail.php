<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Mentor;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Carbon;

class MentorRequestAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Sers Chborng | '.User::getUsername($this->appointment->mentee_id).' requests an appointment',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.request_appointment',
            with: [
                'mentee' => User::getUsername($this->appointment->mentee_id),
                'mentor' => Mentor::getMentorName($this->appointment->mentor_id),
                'opportunity' => Post::getPostTitle($this->appointment->opportunity_id),
                'description' => $this->appointment->description,
                'method' => $this->appointment->method,
                'appointment_datetime' => Carbon::parse($this->appointment->appointment_datetime)->format('F j, Y \a\t g:i A'),
                'status' => $this->appointment->status
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
