@extends('layouts.app1')

@section('content')

<style>.iii[contentEditable="true"]:empty:not(:focus):before {
  content: attr(placeholder)
}
</style>
 	    <div  class="cont"> 
		<div class="container">
			<div class="row">
				<div class="col-4">
				 <div class="box1">
				 
				 <div class="search">
				 
				  <input type="text" class="search-inpt" name="search">
				  <div class="icon-search">
				   <img src="{{asset('img/search.png')}}" width="30px" height="30px" >
				 </div> 
				  </div>
				  
                      @if($users->count())
                        @foreach($users as $user)
                     
 					  <div class="media med">
                    
                 <a href="{{ route('message.conversation', $user->id) }}"><img style="border-radius: 50%;" class="mr-3" src="{{ asset($user->image) }}"  width="100px" height="100px" alt="image"></a>
                  <i style="margin-top:186px; margin-left: 88px;" class="fa fa-circle user-status-icon user-icon-{{ $user->id }}" title="away"></i>

                <div class="media-body">
                  <a style="text-decoration:none;" href="{{ route('message.conversation', $user->id) }}"><h5   class="mt-0 hed"> {{ $user->name }}</h5></a>     
                      <h6 class="hed6">Mahmoud is online</h6> 
                </div>
                  
         </div> 	   
		 
  @endforeach
                    @endif
				  
				  
				  
 				 </div>
				 
				 



				</div>
				<div class="col-8"> 
				
				 <div class="box2">
				    <div class="row">
					  
							<img class="iimg" src=" {{asset('img/6.png')}} " width="90px" height="90px">
							<h4>Chat with Mahmoud</h4>
							<img class="img2" src="{{asset('img/4.png')}} " width="35px" height="35px"  >
							<img class="img2" src="{{asset('img/3.png')}}  " width="35px" height="35px"  >
							<img class="img3" src="{{asset('img/5.png')}} "   height="22px"  >
 					</div>
                     
                    <br>
                    <br>
					 <div   class="row  " >
                            @foreach($message_sender as $msg)
                       @foreach($msg->users as $ss)
                @if($ss->pivot->sender_id != $userId)
				           <div class="col-6 cci">
                                <br>
                               @foreach($msg->users as $img)
						     <img style="border-radius: 50%;" class="img22" src="{{ asset($img->profile_image) }}" width="45px" height="45px"  >
                               @endforeach
							 <!--<input type="text" class="inpt" placeholder="" value="  Hi, how are you?"  >-->
							<div class="chat0"><span class="ch1">{{$msg->message}}   </span></div> 
							 
						   </div>
                        <div class="col-6">
                            </div>
				      @else
                        <div class="col-6">
                            </div>
				  <div  class="col-6">
                        
						 
						     
                   <div class="chat1"><span class="ch1">{{$msg->message}}  </span></div>
							  @foreach($msg->users as $img)
                      <img style="border-radius: 50%;" class="img33" src="{{asset($img->profile_image)}}" width="45px" height="45px"  >
                       @endforeach
 						   </div>
                         @endif
                       @endforeach
                      @endforeach 
				     </div> 
                      <div id="messageWrapper" class="row  ">
				            
				 
				     </div> 
               
				 	 
<!--
					 <div class="row">
					 <div class="col-1">
					 
					 
					 </div>
					  <div class="col-10">
					     <div class ="sendStyle"  >
						  <div class="l">
						  <img   src="{{asset('img/7.png')}}" width="30px" height="30px">
						  </div>
			  <input   class="iii"   id="chatInput"   type="text" placeholder="Type Your Message …...">
							<div class="lr">
								 <img   src="{{asset('img/8.png')}}" width="30px" height="30px">
							</div>
						 </div>
						 </div>
						 <div class="col-1"></div>
					  </div>
-->
 				  
		<div class="row">
					 <div class="col-1">
					 
					 
					 </div>
					  <div class="col-10">
					     <div class ="sendStyle"  >
						  <div class="l">
						  <img   src="{{asset('img/7.png')}}" width="30px" height="30px">
						  </div>
<!--			  <input   class="iii"   id="chatInput"   type="text" placeholder="Type Your Message …...">-->
                             
                             <div contentEditable=true class="chat-input iii"   placeholder="Type Your Message …..." id="chatInput" ></div>
                             
							<div class="lr">
						  <img class="chat-input_two"  src="{{asset('img/8.png')}}" width="30px" height="30px">
							</div>
						 </div>
						 </div>
						 <div class="col-1"></div>
					  </div>
                     
<!--
            <div class="chat-box">
                <div class="chat-input bg-white" id="chatInput" contenteditable="">

                </div>

                <div class="chat-input-toolbar">
                    <button title="Add File" class="btn btn-light btn-sm btn-file-upload">
                        <i class="fa fa-paperclip"></i>
                    </button> |

                    <button title="Bold" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('bold', false, '');">
                        <i class="fa fa-bold tool-icon"></i>
                    </button>

                    <button title="Italic" class="btn btn-light btn-sm tool-items"
                            onclick="document.execCommand('italic', false, '');">
                        <i class="fa fa-italic tool-icon"></i>
                    </button>
                </div>
            </div>
-->
					 
					 
					 
					 
				 </div>

				</div>
			
			
			</div>
		
			
		</div>

     </div>






@endsection

@push('scripts')
    <script>
        $(function (){
            let $chatInput = $(".chat-input");
            let $chatinputtwo = $(".chat-input_two");
            let $chatInputToolbar = $(".chat-input-toolbar");
            let $chatBody = $(".chat-body");
            let $messageWrapper = $("#messageWrapper");


            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);
            let friendId = "{{ $friendInfo->id }}";

            socket.on('connect', function() {
                socket.emit('user_connected', user_id);
            });

            socket.on('updateUserStatus', (data) => {
                let $userStatusIcon = $('.user-status-icon');
                $userStatusIcon.removeClass('text-success');
                $userStatusIcon.attr('title', 'Away');

                $.each(data, function (key, val) {
                    if (val !== null && val !== 0) {
                        let $userIcon = $(".user-icon-"+key);
                        $userIcon.addClass('text-success');
                        $userIcon.attr('title','Online');
                    }
                });
            });

            $chatInput.keypress(function (e) {
               let message = $(this).html();
               
               if (e.which === 13 && !e.shiftKey) {
                   $chatInput.html("");
                   sendMessage(message);
                   return false;
               }
            });
            
            $chatinputtwo.on('click',function(e){
               
           let message = $chatInput.html();
            //  alert(message);
               if (event.button == 0) {
               //    alert(message);
                   $chatInput.html("");
                   sendMessage(message);
                   return false;
               }            
            
            });


            function sendMessage(message) {
                let url = "{{ route('message.send-message') }}";
                let form = $(this);
                let formData = new FormData();
                let token = "{{ csrf_token() }}";

                formData.append('message', message);
                formData.append('_token', token);
                formData.append('receiver_id', friendId);

                appendMessageToSender(message);

                $.ajax({
                   url: url,
                   type: 'POST',
                   data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                   success: function (response) {
                       if (response.success) {
                           console.log(response.data);
                       }
                   }
                });
            }

        function appendMessageToSender(message) {
//                let name = '{{ $myInfo->name }}';
            let image = '{{ $myInfo->profile_image }}';
//                let image = '{!! makeImageFromName($myInfo->name) !!}';
//
//                let userInfo = '<div class="col-md-12 user-info">\n' +
//                    '<div class="chat-image">\n' + image +
//                    '</div>\n' +
//                    '\n' +
//                    '<div class="chat-name font-weight-bold">\n' +
//                    name +
//                    '<span class="small time text-gray-500" title="'+getCurrentDateTime()+'">\n' +
//                    getCurrentTime()+'</span>\n' +
//                    '</div>\n' +
//                    '</div>\n';
//
//                let messageContent = '<div class="col-md-12 message-content">\n' +
//                    '                            <div class="message-text">\n' + message +
//                    '                            </div>\n' +
//                    '                        </div>';
//
//
//                let newMessage = '<div class="row message align-items-center mb-2">'
//                    +userInfo + messageContent +
//                    '</div>';
//                
//                let msg = '';
                
              let newMessage = '  <div class="col-6 cci">'+
                               ' <br>'+'<img style="border-radius: 50%;" class="img22" src="{{asset($myInfo->profile_image)}}" width="45px" height="45px"  >'
                +'<div class="chat0"><span class="ch1">' + message +   '</span></div> '
 							 +
						'  </div>' +
                       ' <div class="col-6">'+
                          '  </div>';
                

                $messageWrapper.append(newMessage);
            }

            function appendMessageToReceiver(message) {
    //                let name = '{{ $friendInfo->name }}';
                let image = '{{ $friendInfo->profile_image }}';
                
//                let image = '{!! makeImageFromName($friendInfo->name) !!}';
//
//                let userInfo = '<div class="col-md-12 user-info">\n' +
//                    '<div class="chat-image">\n' + image +
//                    '</div>\n' +
//                    '\n' +
//                    '<div class="chat-name font-weight-bold">\n' +
//                    name +
//                    '<span class="small time text-gray-500" title="'+dateFormat(message.created_at)+'">\n' +
//                    timeFormat(message.created_at)+'</span>\n' +
//                    '</div>\n' +
//                    '</div>\n';
//
//                let messageContent = '<div class="col-md-12 message-content">\n' +
//                    '                            <div class="message-text">\n' + message.content +
//                    '                            </div>\n' +
//                    '                        </div>';
//
//
//                let newMessage = '<div class="row message align-items-center mb-2">'
//                    +userInfo + messageContent +
//                    '</div>';
                
                
              let newMessage = '   <div class="col-6"> </div>'+
                           
				'  <div  class="col-6">'+
                        
						 
						     
                  ' <div class="chat1"><span class="ch1"> '+ message.content +'  </span></div>'+
							 
                   '  <img style="border-radius: 50%;" class="img33" src="{{asset($friendInfo->profile_image)}}" width="45px" height="45px"  ></div>';
 						   


                $messageWrapper.append(newMessage);
            }

               socket.on("private-channel:App\\Events\\PrivateMessageEvent", function (message)
             {
                console.log('ddddddddd');
               appendMessageToReceiver(message);
            });

        });
    </script>
@endpush
