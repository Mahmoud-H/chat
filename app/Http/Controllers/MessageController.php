<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\PrivateMessageEvent;

class MessageController extends Controller
{
    public function __construct()
     {
         
       $this->middleware(['auth']);  
     }
    public function conversation($userId) {
        $users = User::where('id', '!=', Auth::id())->get();
        $friendInfo = User::findOrFail($userId);
        
        $myInfo = User::find(Auth::id());
     //  dd($friendInfo->messages) ;
        // dd(Auth::id());
//    dd($userId);
      $sender_id = Auth::id();
      //  dd($sender_id);
//$message_sender= Message::with('users')->whereHas('users',function ($query) use ($userId){
//$query->where('sender_id','=',Auth::id());
//$query->where('receiver_id','=',$userId);
//})->get();
 
//        $message_receiver= Message::with('users')->whereHas('users',function ($query) use ($userId){
//$query->where('sender_id','=',$userId);
//$query->where('receiver_id','=',Auth::id());
//})->get();
//
        
 
        
 $message_sender= Message::with('users')->whereHas('users',function ($query) use ($userId){ $query->whereIn('sender_id',[Auth::id(),$userId])->wherein('receiver_id',[Auth::id(),$userId]); })->get();

     //   echo $message_sender;
        foreach($message_sender as $msg)
        {
        //  echo   $msg->users."<br>";
            foreach($msg->users as $ss)
            {
                
                if($ss->pivot->sender_id == $userId)
                {
               //     echo $ss->pivot->sender_id."<br>";
                }
            //    echo   $msg->message."<br>";
            }
        }
        
        $this->data['users'] = $users;
        $this->data['friendInfo'] = $friendInfo;
        $this->data['myInfo'] = $myInfo;
        $this->data['users'] = $users;
        $this->data['message_sender'] = $message_sender;
       // $this->data['message_receiver'] = $message_receiver;
        $this->data['userId'] = $userId;
        
       return view('message.conversation', $this->data);
        
    }

    public function sendMessage(Request $request) {
        $request->validate([
           'message' => 'required',
           'receiver_id' => 'required'
        ]);

        $sender_id = Auth::id();
        $receiver_id = $request->receiver_id;

        $message = new Message();
        $message->message = $request->message;

        if ($message->save()) {
            try {
                $message->users()->attach($sender_id, ['receiver_id' => $receiver_id]);
                $sender = User::where('id', '=', $sender_id)->first();

                $data = [];
                $data['sender_id'] = $sender_id;
                $data['sender_name'] = $sender->name;
                $data['receiver_id'] = $receiver_id;
                $data['content'] = $message->message;
                $data['created_at'] = $message->created_at;
                $data['message_id'] = $message->id;

                event(new PrivateMessageEvent($data));

                return response()->json([
                   'data' => $data,
                   'success' => true,
                    'message' => 'Message sent successfully'
                ]);
            } catch (\Exception $e) {
                $message->delete();
            }
        }
    }
}
