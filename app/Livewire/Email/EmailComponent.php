<?php

namespace App\Livewire\Email;

use App\Mail\MessageMail;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Email')]
class EmailComponent extends Component
{
    public $subject;
    public $message;

    protected $rules = [
        'subject'=>'required|min:3',
        'message'=>'required|min:5'
    ];

    public function render()
    {
        $authName = auth()->user()->name;
        $authEmail = auth()->user()->email;

        return view('livewire.email.email-component',compact('authName','authEmail'));
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function saveEmail(){
        $email = new Email();
        $email->name = auth()->user()->name;
        $email->email = auth()->user()->email;
        $email->subject = $this->subject;
        $email->message = $this->message;
        $this->validate();
        
        // $email->save();
        try {
            $sendEmail = Mail::to(
                'anderle88@gmail.com',
                'Diogo Anderle',
            )->send(new MessageMail([
                'fromName' => auth()->user()->name,
                'fromEmail' => auth()->user()->email,
                'subject' => $email->subject,
                'message' => $email->message
                
                
            ]));
            $this->dispatch('msg', 'Email enviado com sucesso','success');
            dump('Email sent', $sendEmail);
        } catch (\Throwable $th) {
            $this->dispatch('msg', $th,'danger');
        }
       
        
    }
}
