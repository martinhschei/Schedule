<?php

include "Schedule.php";

switch($_SERVER["REQUEST_METHOD"])
{

    case("GET"):
    {
        if(isset($_GET["cmd"]))
        {
            if($_GET["cmd"] === "next_interval")
            {
                if(isset($_GET["current_view"]))
                {
                    $start = strtotime("+ 1 week", $_GET["current_view"]);
                }
                else
                {
                    $start = time();
                }

                $new_interval = (new Schedule)->assemble_overview("07:00", 4, 7, 5, $start);
                echo json_encode(array("interval" => $new_interval));
            }
        }
    }
}