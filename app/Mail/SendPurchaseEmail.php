<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPurchaseEmail extends Mailable
{
  use Queueable, SerializesModels;

  private string $xmlURL;

  /**
   * Create a new message instance.
   * @param xmlURL url de acesso ao arquivo
   *
   * @return void
   */
  public function __construct(
    string $xmlURL
  ) {
    $this->xmlURL = $xmlURL;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Nova venda realizada com sucesso')
      ->view('emails.new-purchase')
      ->with(['urlAccessXML' => $this->xmlURL]);
  }
}
