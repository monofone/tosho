/**
 * provide the toshie handling functionality
 */
$(document).ready(function(){
  $('.invitations li.accepted').each(function(index, item){
    $(item).draggable({revert: 'invalid'});
  });
  
  $('.toshidropzone').droppable({
    hoverClass:'ui-state-droppable',
    drop: function(event, ui){
      var elementId = ui.draggable[0].id.substr(20);
      
      $.ajax(Routing.generate('add_toshi_to_list', {toshiid: elementId}), {
        success: function(result){
          $('.toshilist' ).find( ".placeholder" ).remove();
          $('.toshilist').append("<li>"+result.username+"</li>");
          $('.invitations' ).find( '#invitation-toshi-id-'+result.id ).remove();
        } 
      });
    }
  });
});
