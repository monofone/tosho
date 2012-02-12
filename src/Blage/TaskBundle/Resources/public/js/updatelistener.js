$(document).ready(function(){
  var pusher = new Pusher(pusher_api_key);
  var channelName = User.username+"-"+channelId;
  var channel = pusher.subscribe(channelName);
  channel.bind('new-item', function(data){
    mappedTask = new Task(data);
    viewModel.tasks.push(mappedTask);
    });  
});