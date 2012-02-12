/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function Task(data){
  this.id = data.id;
  this.tasklist_id = data.tasklist_id;
  this.title = ko.observable(data.title);
  this.isDone = ko.observable(data.isDone);
}

function TaskListViewModel()
{
  var self = this;
  self.tasks = ko.observableArray([]);
  self.newTaskText = ko.observable();
  self.incompleteTasks = ko.computed(function() {
    return ko.utils.arrayFilter(self.tasks(), function(task) {
      return !task.isDone() &&  !task._destroy;
    });
  });

  // Operations
  self.addTask = function() {
    task = new Task({
      title: this.newTaskText(),
      isDone: false,
      tasklist_id: tasklistId
    })
    self.newTaskText("");
    self.save(task);    
  };
  
  self.doneTask = function(task){
    if(task.isDone()){
      task.isDone(false);
    }else{
      task.isDone(true);
    }
    self.updateTask(task);
  };
  
  self.removeTask = function(task) {
    self.tasks.destroy(task);
    self.updateTask(task);
  };
  
//    // Load initial state from server, convert it to Task instances, then populate self.tasks
//  $.getJSON(Routing.generate('blage_task_default_savetasks',{ username: User.username, taskListId: 1 }), function(allData) {
//      var mappedTasks = $.map(allData, function(item) { 
//        return new Task(item) 
//      });
//      self.tasks(mappedTasks);
//  });
  
  self.save = function(task){
    self.storeTask(task, function(result){
        if(task){
          task.id = result.id;
          self.tasks.push(task); 
        }
        $('#msg').text('Neuer Tasks: ' + result.title + ' hinzugefügt ');
        $('#msg').show();
        setTimeout(function(){
          $('#msg').fadeOut('slow');
        }, 2000);
      });
  };
  
  self.updateTask = function(task){
    self.storeTask(task, function(result){
      var text = 'Update gespeichert';
      if(result.error){
        $('#msg').attr('class', 'error');
        text = result.error_msg;
      }
      $('#msg').text(text);
        $('#msg').show();
        setTimeout(function(){
          $('#msg').fadeOut('slow');
          $('#msg').attr('class', '');
        }, 2000);
    });
  };
  
  self.storeTask = function(task, successCallback){
    $.ajax(Routing.generate('blage_task_default_savetasks'), {
      data: 'data=' + ko.toJSON(task),
      type: 'post',
      success: successCallback
    })    
  };
}

viewModel = new TaskListViewModel();
ko.applyBindings(viewModel);
