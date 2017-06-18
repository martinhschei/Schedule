$(document).ready(function() {
    
   

});


function next_interval()
{
    var current_interval = $("#table-overview").data("start");
    console.log(current_interval);

    Ajax( { cmd : "next_interval", current_view : current_interval } , new_interval_callback);
}

function one_day_forward()
{

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

function new_interval_callback(result)
{
    console.log(result);
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
