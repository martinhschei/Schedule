<?php

class Schedule
{

    private $mySchedule;

    // split the hour in how many chunks?
    const DEFAULT_HOUR_SLICE = 4;
    // .....hours per day....
    const DEFAULT_HOURS_PER_DAY = 8;
    // when to start
    const DEFAULT_OPENING_HOUR = '07:00';
    // how many days?
    const DEFAULT_DAYS = 8;
    
    private $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

    private $header_templ = <<<HTML

        <th class="booking-table-heading" data-dag="__DATE__">
            __DATE__
        </th>

HTML;

    private $table_head = <<<HTML
    <thead>
        <tr>
            <th class='week-number'> __WEEK__NUMBER__ </th> 
            __THE__HEADERS__
        </tr>
    </thead>


HTML;

    private $td = <<<HTML

    <div class="time-slice-btn">
        <label>
            <td class='hour-column' rowspan='__HOUR__SLICE__'>   
                 <input type='checkbox' hidden >
                <span> __CONTENT__ </span> 
            </td>
        </label>
    </div>

HTML;

    function __construct()
    {
        $this->mySchedule = json_decode(file_get_contents("schedule.json"),true);
    }

    function create_headers($num_of_days, $start_date)
    {
        $finished_headers = '';
        $temp_date = date("Y-m-d", $start_date);
        $adj_date = new DateTime($temp_date);

        for($i = 0; $i < $num_of_days; $i++)
        {
            $finished_headers .= str_replace(
                "__DATE__",
                $adj_date->format("D-d-M-Y"),
                $this->header_templ
            );
            $adj_date->add(new DateInterval("P1D"));
        }

        return $finished_headers;
    }

    function get_unvailable_days($num_of_days, $start_date, $days_to_skip)
    {
        $curr_day = date("l", $start_date);
        $skipping_indexes = [];
        // ....for the number of days we will print...
        for($i = 0; $i < $num_of_days; $i++)
        {
            // ..check if some of them should be skipped...
            for($j = 0; $j < count($days_to_skip); $j++)
            {
                if($curr_day == $days_to_skip[$j])
                {
                    $skipping_indexes[] = $i;
                }
            }
            $curr_day = date("l", strtotime("+ 1 day", strtotime($curr_day)));
        }
        return $skipping_indexes;
    }

    function assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open, $start)
    {
        $unvailable_days = $this->get_unvailable_days($num_of_days, $start, $this->mySchedule["days-not-available"]);
        //$busy = $this->get_busy_time($this->mySchedule["busy"]);

        $table_head = str_replace( 
                [ "__THE__HEADERS__", "__WEEK__NUMBER__"], 
                [$this->create_headers($num_of_days, $start), date("W", $start) ],
                $this->table_head);
        
        //add the info used to create table as a data dataset value
        $table_body = "<tbody id='table-overview' data-interval='$opening_hour,$hour_slice,$num_of_days,$hours_open,$start'>";
        $hour = new DateTime($opening_hour);

        for($j = 0; $j < $hours_open; $j++)
        {
            if($j !== 0) { $hour->add(new DateInterval("PT1H")); }

            $table_body .= "<tr>";
            $table_body .= "<td class='hour-column' rowspan='" . $hour_slice . "'>  <span> " . $hour->format('H') . " </span> </td>";
            $row_added =  true;
            
            for($x = 0; $x < $hour_slice; $x++)
            {
                if(!$row_added) { $table_body .= "<tr>"; }
                for($i = 0; $i < $num_of_days; $i++)
                {
                    if(!in_array($i, $unvailable_days))
                    {
                        $td_date = date("D-d-M-Y", strtotime("+ " . $i . " days", $start));
                        if($this->mySchedule["busy"])
                        {
                            foreach($this->mySchedule["busy"] as $busy_time)
                            {
                                if($td_date == $busy_time["day"])
                                {   
                                    // check if the time is booked, not only the day.
                                    $table_body .= "<td class='booked' data-timeindex='not available'> <span>  </span> </td>";
                                }
                                else
                                {
                                    $slice_interval = $this->create_slice_string($hour_slice, $x, $hour);
                                    $table_body .= 
                                    "<td class='time-interval' 
                                    data-date='$td_date' 
                                    data-interval='$slice_interval'> 
                                    <label class='hour-slice'> 
                                    <input type='checkbox' hidden> <span> " . $slice_interval . " </span> 
                                    </label> 
                                    </td>";
                            }
                            }
                        }
                        
                      
                    }
                    else
                    {
                        $table_body .= "<td class='not-available' data-timeindex='not available'> <span> </span> </td>";
                    }
                   
                }

                $row_added = false;
                $table_body .= "</tr>";

            }
        }

        $table_body .= "</tbody>";
        return "<table class='table-responsive'>" . $table_head .  $table_body . "</table>";
    }

    private function create_slice_string($slicing, $current_slice, $current_hour)
    {
        // how many minutes per slice?
        $minutes = (60 / $slicing);

        // which hour are we in?
        $hour_prefix = $current_hour->format("H");
        
        // how many minutes passed the hour does the current slice start?
        $current_slice_min_passed = $minutes * $current_slice;

        if($current_slice_min_passed === 0)
        {
            $current_slice_min_passed = "00";
        }

        // ..when does it end?

        $current_slice_end = $current_slice_min_passed + $minutes;

        // does the current slice end when the next hour starts? 07:45 + 15 minutes = 08:00
        if($current_slice_end == 60)
        {
            $current_hour_clone = new DateTime($current_hour->format("H:i"));
            $end_hour_prefix = $current_hour_clone->add(new DateInterval("PT1H"))->format("H");
            $current_slice_end = "00";
        }
        else
        {
            $end_hour_prefix = $hour_prefix;
        }

        return $hour_prefix . ":" . $current_slice_min_passed . " - " . $end_hour_prefix . ":" . $current_slice_end;
    
    }
}

    // assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open, $start_date);
    //(new Schedule)->assemble_overview("07:00", 4, 8, 8, strtotime("+ 3 days"));

?>
