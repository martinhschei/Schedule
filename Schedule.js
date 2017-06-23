function shift_view(interval)
{
    var current_view_info = $("#table-overview").data("interval");
    Ajax( { cmd : interval, current : current_view_info } , update_view_callback);
}

function Ajax(command, callback)
{	
    console.log(command);

	$.ajax({
		method: "GET",
		url: "scheduler_backend.php",
		dataType: "json",
		data: command,
		success: callback,
	});
}

function update_view_callback(result)
{
	if(result)
    {
        $("#schedule-view").html(result.interval);
        hook_up_schedule_table_events();
    }
}

function hook_up_schedule_table_events()
{
     $(".time-interval").click(function(){

        var timeInterval = $(this).data("interval");
        var date = $(this).data("date");
        console.log(date + " / " + timeInterval);
    }); 
}
