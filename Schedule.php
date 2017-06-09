<?php

class Schedule
{

    const DEFAULT_HOUR_SLICE = 4;

    const DEFAULT_HOURS_PER_DAY = 8;

    const DEFAULT_OPENING_HOUR = '08:00';

    const DEFAULT_DAYS = 5;
    
    private $behandler;

    private $days = ["Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag", "Søndag"];

    private $header_templ = <<<HTML

        <th class="booking-table-heading">
            <span data-dag="day_index">DAY</span>
        </th>

HTML;
    private $table_head = <<<HTML

    <thead>
        <tr>
            <th> </th> <!-- Top left corner left intentionally blank -->
            __THE__HEADERS__
        </tr>
    </thead>


HTML;

    function __construct()
    {

    }

    //  (new Schedule)->assemble_overview("08:00", 4, 5, 8);

    function create_headers($num_of_days)
    {
        $ass_headers = '';
        for($i = 0; $i < $num_of_days; $i++)
        {
            $ass_headers .= str_replace("DAY", $this->days[$i], $this->header_templ);
        }
        return $ass_headers;
    }

    function assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open)
    {
        $table_head = str_replace("__THE__HEADERS__", $this->create_headers($num_of_days), $this->table_head);
        $table_body = "<tbody>";
        $hour = new DateTime($opening_hour);

        for($j = 0; $j < $hours_open; $j++)
        {
            if($j !== 0) { $hour->add(new DateInterval("PT1H")); }
            $table_body .= "<tr>";
            $table_body .= "<td class='hour-coloumn' rowspan='" . $hour_slice . "'> <span> " . $hour->format('H') . " </span> </td>";
            $row_added =  true;
            
            for($x = 0; $x < $hour_slice; $x++)
            {
                if(!$row_added) { $table_body .= "<tr>"; }
                for($i = 0; $i < $num_of_days; $i++)
                {
                    /*$table_body .= "<td data-timeindex='$i-$j-$x' class='hour-slice'> | slice:$x - hour:$j - dag:$i | </td>";*/
                    $slice_interval = $this->create_slice_string($hour_slice, $x, $hour);
                    $table_body .= "<td data-timeindex='$i-$j-$x' class='hour-slice'> " . $slice_interval. " </td>";
                }
                $row_added = false;
                $table_body .= "</tr>";

            }
        }

        $table_body .= "</tbody>";
        echo "<table>" . $table_head .  $table_body . "</table>";
    }

    private function create_slice_string($slicing, $current_slice, $current_hour)
    {
        // how many minutes per slice?
        $minutes = (60 / $slicing);

        // which hour are we in?
        $hour_prefix = $current_hour->format("H");
        
        // how many minutes passed the whole hour does the current slice start?
        $current_slice_min_passed = $minutes * $current_slice;

        if($current_slice_min_passed === 0)
        {
            $current_slice_min_passed = "00";
        }

        // ..when does it end?

        $current_slice_end = $current_slice_min_passed + $minutes;

        // does the current slice end when the next hour starts?
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

    // assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open)
    (new Schedule)->assemble_overview("07:00", 4, 7, 8);

?>