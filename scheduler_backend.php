<?php

include "Schedule.php";

switch($_SERVER["REQUEST_METHOD"])
{
    case("GET"):
    {
        // the information is sent like this:
        // $opening_hour:$hour_slice:$num_of_days:$hours_open:$start
        //
        // function assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open, $start)
        if(isset($_GET["cmd"]))
        {
            list($opening, $slice, $days, $hours, $start_date) = explode("," , $_GET["current"]);
            switch($_GET["cmd"])
            {
                case("next"):
                {
                    $new_start = strtotime("+ ". $days . " days", $start_date);
                    $new_interval = (new Schedule)->assemble_overview($opening, $slice, $days,$hours, $new_start);
                    echo json_encode(array("interval" => $new_interval));
                    break;
                }

                case("last"):
                {
                    $new_start = strtotime("- ". $days . " days", $start_date);
                    $new_interval = (new Schedule)->assemble_overview($opening, $slice, $days,$hours, $new_start);
                    echo json_encode(array("interval" => $new_interval));
                    break;
                }

                case("oneDay"):
                {
                    $new_start = strtotime("+ 1 day", $start_date);
                    $new_interval = (new Schedule)->assemble_overview($opening, $slice, $days,$hours, $new_start);
                    echo json_encode(array("interval" => $new_interval));
                    break;
                }

                case("lastDay"):
                {
                    $new_start = strtotime("- 1 day", $start_date);
                    $new_interval = (new Schedule)->assemble_overview($opening, $slice, $days,$hours, $new_start);
                    echo json_encode(array("interval" => $new_interval));
                    break;
                }
            }
        }
    }
}