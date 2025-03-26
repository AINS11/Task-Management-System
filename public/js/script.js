toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "2000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

$(document).ready(function() {
    $('.add-btn button').on('click', ()=>{
        $('.modal').css('display','flex');
        $(".modal-content h2").text("Add Task");
        $('.modal-buttons .update-btn').text('Save')
        $('.modal-buttons .update-btn').attr('class','save-btn')
        $('#task-title').val('');
        $('#task-desc').val('');
        $('#task-due-date').val('');
    })

    $('.modal .cancel-btn').on('click', ()=>{
        $('.modal').css('display','none');
    })

    $(document).on('change', '.task-action', function() {
        let action = $(this).val();
        let taskItem = $(this).closest('li');
        let id=$(taskItem).find('select').attr('task_id');
        if (action === "delete") {
            removeTask(id);
            taskItem.remove(); // Removes the task
        } else if (action === "edit") {
            editTask(id);
        } else if (action === "completed") {
            changeStatus(id,'completed');

        }  else if (action === "pending") {
            changeStatus(id,'pending');
        }

        $(this).val("pending"); // Reset dropdown to "Pending" after action
    });

    $(document).on('click','.modal-buttons .save-btn',()=>{

        let title = $('#task-title').val().trim();
        let description = $('#task-desc').val().trim();
        let priority = $('#task-priority').val();
        let dueDate = $('#task-due-date').val();

        let today = new Date().toISOString().split('T')[0];
    
        // Validation checks
        if (!title) {
            $('.Ttitle').text("Title is required.");
            $('.Ttitle').css('display','block');
            return;
        }
        if (!dueDate) {
            $('.Ddate').text("Due date is required.");
            $('.Ddate').css('display','block');
            $('.Ddate').css('padding-bottom','2px');
            return;
        }
        if (dueDate <= today) {
            $('.Ddate').text("Due date must be in the future.");
            $('.Ddate').css('display','block');
            $('.Ddate').css('padding-bottom','2px');
            return;
        }
    
        let taskData = {
            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
            title: title,
            description: description,
            priority: priority,
            due_date: dueDate
        };

        $.ajax({
            url: "/tasks",
            type: "POST",
            data: taskData,
            success: function(response) {
                if (response.data) {
                    toastr.success('Task Added Successfully') 
                    setTimeout(()=>{
                        location.reload(); // Reload page to reflect changes
                    },1000);
                } else {
                    alert('Task added, but no data received.');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to add task. Check your inputs.')
            }
        });
        
    });
});

function removeTask(id) {
    $.ajax({
        url: '/tasks/' + id, // Laravel route
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(response) {
            if (response.success) {
                $('#task-' + id).remove(); // Remove task from UI
                toastr.success("Task deleted successfully!");
                setTimeout(()=>{
                    location.reload(); // Reload page to reflect changes
                },1000);
            } else {
                toastr.error("Failed to delete task.");
            }
        },
        error: function(xhr) {
            toastr.error("An error occurred. Please try again.");
        }
    });
}

function editTask(id) {
    $.ajax({
        url: "/tasks/" + id + "/edit",
        type: "GET",
        success: function(response) {
            let task = response.task;

            // Populate modal fields with existing task data
            $("#task-id").val(task.id);
            $("#task-title").val(task.title);
            $("#task-desc").val(task.description);
            $("#task-priority").val(task.priority);
            $("#task-due-date").val(task.due_date);

            // Change modal title to "Edit Task"
            $(".modal-content h2").text("Edit Task");
            $('.modal-buttons .save-btn').text('Update')
            $('.modal-buttons .save-btn').attr('class','update-btn')
            // Show modal
            $("#custom-modal").css('display','flex');
        },
        error: function() {
            alert("Failed to fetch task details.");
        }
    });
}

$(document).on('click','.update-btn',function() {
    let id = $("#task-id").val();
    let title = $('#task-title').val().trim();
    let dueDate = $('#task-due-date').val();

    let today = new Date().toISOString().split('T')[0];

    // Validation checks
    if (!title) {
        $('.Ttitle').text("Title is required.");
        $('.Ttitle').css('display','block');
        return;
    }
    if (!dueDate) {
        $('.Ddate').text("Due date is required.");
        $('.Ddate').css('display','block');
        $('.Ddate').css('padding-bottom','2px');
        return;
    }
    if (dueDate <= today) {
        $('.Ddate').text("Due date must be in the future.");
        $('.Ddate').css('display','block');
        $('.Ddate').css('padding-bottom','2px');
        return;
    }

    $.ajax({
        url: '/tasks/'+id,
        type: 'PUT',
        data: {
            title: $("#task-title").val(),
            description: $("#task-desc").val(),
            priority: $("#task-priority").val(),
            due_date: $("#task-due-date").val(),
            _token: $('meta[name="csrf-token"]').attr("content")
        },
        success: function(response) {
            toastr.success("Task Updated successfully!");
            setTimeout(()=>{
                location.reload(); // Reload page to reflect changes
            },1000);
        },
        error: function(response) {
            alert("Error saving task.");
        }
    });
});

// Cancel button to close modal
$(".cancel-btn").click(function() {
    $("#custom-modal").hide();
});


function changeStatus(taskId, status = 'pending') {
    $.ajax({
        url: "/tasks/" + taskId,
        type: "PATCH",
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message); // Display success notification
                location.reload(); // Reload page to reflect changes
            }
        },
        error: function(xhr) {
            toastr.error('Failed to update task status');
        }
    });

}