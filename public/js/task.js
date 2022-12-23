$(document).ready(function(){
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		startDate: new Date(),
	});

	$('#start_date').datepicker().on('changeDate', function(ev) {
		var startday = new Date(ev.date.valueOf());
		var afterday = new Date(startday.getFullYear(),startday.getMonth(),startday.getDate()+1);
		$('#end_date').datepicker('setStartDate', new Date(afterday));
	});

	$('#end_date').datepicker().on('changeDate', function(ev){
		var afterday = new Date(ev.date.valueOf());
		var startday = new Date(afterday.getFullYear(),afterday.getMonth(),afterday.getDate()-1);
		$("#start_date").datepicker('setEndDate', new Date(startday));
	});

	$('#formtask').validate({
		rules: {
			period: {
				required: true
			},
			title: {
				required: true
			},
			start_date: {
				required: true
			},
			end_date: {
				required: function() {
					if($('#period').val() != 9) {
						return true;
					}
					else {
						return false;
					}
				}
			},

		},
		messages: {
			period: {
				required: 'Please select period.'
			},
			title: {
				required: 'Please enter title.'
			},
			start_date: {
                required: 'Please select start date.'
            },
            end_date: {
                required: 'Please select end date.'
			}
		},
		submitHandler: submitHandlerCreatetask
	});

	loadData();

	$('#period').change(function(){
		if($(this).val() == 9) {
			$('.end-date-box').hide();
		}
		else {
			$('.end-date-box').show();
		}
	});
});

function completeTask(task_id) {
    ajaxUpdate(baseurl() + '/task/complete', { task_id: task_id }, function(responseText, statusText) {
        hideLoader();
        if(statusText == 'success') {
            if(responseText.type == 'success') {
                loadData();
            }
            else {
                showError(responseText.caption);
            }
        }
        else {
            showError('Unable to communicate with server.');
        }
    }, true);
}

function deleteTask(task_id) {
    ajaxUpdate(baseurl() + '/task/delete', { task_id: task_id }, function(responseText, statusText) {
        hideLoader();
        if(statusText == 'success') {
            if(responseText.type == 'success') {
                loadData();
            }
            else {
                showError(responseText.caption);
            }
        }
        else {
            showError('Unable to communicate with server.');
        }
    }, true);
}

function pendingTask(task_id) {
    ajaxUpdate(baseurl() + '/task/pending', { task_id: task_id }, function(responseText, statusText) {
        hideLoader();
        if(statusText == 'success') {
            if(responseText.type == 'success') {
                loadData();
            }
            else {
                showError(responseText.caption);
            }
        }
        else {
            showError('Unable to communicate with server.');
        }
    }, true);
}

function submitHandlerCreatetask(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseCreatetask,
        error: formResponseError
    });
}

function formResponseCreatetask(responseText, statusText){
	var form = $('#formtask');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			$('#createTaskModal').modal('hide');
			loadData();
		}
		else {
			showError(responseText.caption, responseText.errormessage);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError(getTranslation('Unable to communicate with server.'));
	}
}

function loadData() {
    showLoader();
    ajaxFetch(baseurl() + '/task/load', null, formResponseLoadTask);
}

function formResponseLoadTask(responseText, statusText) {
	hideLoader();
	responseText = jQuery.parseJSON(responseText);
	if(statusText == 'success') {
		$('#today-task').html(responseText.today_tasks_html);
		$('#tomorrow-task').html(responseText.tomorrow_tasks_html);
		$('#next-week-task').html(responseText.nextweek_tasks_html);
		$('#next-month-task').html(responseText.nextmonth_tasks_html);
		$('#next-task').html(responseText.next_tasks_html);
		$('#completed-task').html(responseText.completed_tasks_html);
	}
	else {
		showError('Unable to communicate with server.');
	}
}