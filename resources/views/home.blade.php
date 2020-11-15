@extends('layouts.app1')


@section('content')

  
	    <div  class="cont"> 
		<div class="container">
			<div class="row">
				<div class="col-4">
				 <div class="box1">
				 
				 <div class="search">
				 
				  <input type="text" class="search-inpt" name="search">
				  <div class="icon-search">
				   <img src="img/search.png" width="30px" height="30px" >
				 </div>
				  </div>
				   @if($users->count())
                        @foreach($users as $user)
 				  <div class="media med">
                    
        <a href="{{ route('message.conversation', $user->id) }}"><img style="border-radius: 50%;" class="mr-3" src="{{ asset($user->image) }}" width="100px" height="100px" alt="image"></a>
                  

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
				    
					 
					 
				 	 
					 
					
					 
					 
					 
					 
					 
				 </div>

				</div>
			
			
			</div>
		
			
		</div>

     </div>


 @endsection



@push('scripts')
    <script>
        $(function (){
            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8005';
            let socket = io(ip_address + ':' + socket_port);

            socket.on('connect', function() {
              //  alert("test");
               socket.emit('user_connected', user_id);
            });

            socket.on('updateUserStatus', (data) => {
                 let $userStatusIcon = $('.user-status-icon');
                 $userStatusIcon.removeClass('text-success');
            $userStatusIcon.attr('title', 'Away');
// console.log(data);
                $.each(data, function (key, val) {
                   if (val !== null && val !== 0) {
                       console.log(key);
                      let $userIcon = $(".user-icon-"+key);
                      $userIcon.addClass('text-success');
                      $userIcon.attr('title','Online');
                   }
                });
            });
        });
    </script>
@endpush










