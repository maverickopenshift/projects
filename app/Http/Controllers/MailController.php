<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

class MailController extends Controller
{
  public function basic_email(){
    $data=array('name'=>"Annisa Dwi Aguslita", 'body'=>"test email");
    Mail::send(['text'->'mail'], $data, function($message){
      $message->to('agta.dw27@gmail.com','Agta Dwi Gustava')->subject('Send mail from laravel with Basic');
      $message->from('inartdemo@gmail.com','Do Not Reply');
    });
    echo 'Basics Email was Sent!';
  }

//   public function html_email(){
//     $data=array['name'=>'Annisa Dwi Aguslita']
//     Mail::send('text'->'mail'], $data, function($message){
//       $message->to('agta.dw27@gmail.com','Agta Dwi Gustava')->subject('Send mail from laravel with Basic');
//       $message->from('inartdemo@gmail.com','Do Not Reply');
//     });
//     echo 'Basics Email was Sent!';
// }
