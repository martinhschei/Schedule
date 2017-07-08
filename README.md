# Schedule
Small class for creating a booking/events/reminder table with HTML, PHP and JS.

used like this: 
 //assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open, $start)
echo (new Schedule)->assemble_overview( "07:00", 4, 7, 8, time() );   


see screenshot in repo (Schedule.png) to see what it looks like.
