<?php

namespace App\Mail;
use App\Models\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $teacher;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param Teacher $teacher
     * @param string $password
     * @return void
     */
    public function __construct(Teacher $teacher, string $password)
    {
        $this->teacher = $teacher;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bienvenue sur notre plateforme')
                    ->markdown('emails.teacher_created'); // Assurez-vous que le chemin correspond au nom de votre vue Blade
    }
}
