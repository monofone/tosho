var nconf = require('nconf');
var nMemcached = require('memcached');


//read config from file
nconf.file({file: '../app/config/nodeapp.json'});

nconf.defaults({
  'memcache': {
    'host':'localhost',
    'port':11211
  },
  'http': {
    'port': 3000
  }
});

memcacheUri = nconf.get('memcache:host')+':'+nconf.get('memcache:port');
var memcache = new nMemcached(memcacheUri);

var io = require('socket.io').listen(nconf.get('http:port'));

io.sockets.on('connection', function (socket) {
  socket.on('userConnect', function (data) {
    // create a listen id for the user
    memcacheid = data.username + "-" +data.listId;
    socket.set('memcacheid', memcacheid);
    // store into memcache so application can read this      
    // store for 900 sec only
    memcache.set(memcacheid, 'true', 900, function(err, Success){
      if(err){
        console.log(err);
      }
    });
  });
  
  socket.on('disconnect', function(){
    //get the id under which this user is registered
    socket.get('memcacheid', function(err, cacheid){
      if(err){
        console.log(err);
      }else{
        // remove from memcached
        memcache.del(cacheid, function(err, result){
          if(err){
            console.log(err);
          }
        });        
      }
    });
  });
    
});