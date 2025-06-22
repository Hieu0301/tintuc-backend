<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;

class NewArticleNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $article;
    public function __construct($article)
    {
        $this->article = $article;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Article Notification',
        );
    }

    // /**
    //  * Get the message content definition.
    //  */
    // // ✅ Dùng markdown
    // public function content(): Content
    // {
    //     return new Content(
    //         markdown: 'emails.article_notification',
    //     );
    // }

    public function build()
    {
        return $this->subject('📰 Bài viết mới từ Tin Tức')
            ->view('emails.article_notification')
            ->with(['article' => $this->article]);
    }




    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
