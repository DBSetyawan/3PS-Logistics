<?php
namespace warehouse\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;
/**
     * Create a new message instance.
     *
     * @return void
     */

     protected $user;

public function __construct(\warehouse\User $user)
    {
        $this->user = $user;
    }
/**
     * Build the message.
     * Test success, but not display route link to users.
     * @return $this
     */
    // public function build()
    // {
    //     $tokens = $this->user->token_register;
    //     return $this->view('auth.redirectmailink')->with(compact(
    //         'tokens'
    //     ));
    // }

    /**
     * Build the message.
     * Test success, but not display route link to users.
     * @return $this
     */
    public function build()
    {   
        $link = route('activating-account',$this->user->token_register);
        return $this->view('auth.redirectmailink')
                ->with(compact([
                    'link', $link
                ]));
    }
}