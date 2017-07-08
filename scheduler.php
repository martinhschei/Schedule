<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="schedule.css">
    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous">
    </script>

    <script>

        $(document).ready(function() {
          console.log("Ready");
          hook_up_schedule_table_events();

        });

    </script>

    </head>
    <body>

        <div class="container">

          <div class="row">

            <div class="col-xs-8 col-xs-offset-2">

              <div id="buttons" style="padding-top:20px; padding-bottom:20px;">
                <button class="btn btn-default" onclick="shift_view('next')"> Next interval </button>
                <button class="btn btn-default" onclick="shift_view('last')"> Back one interval </button>
                <button class="btn btn-default" onclick="shift_view('oneDay')"> Shift one day forward </button>
                <button class="btn btn-default" onclick="shift_view('lastDay')"> Shift one day back </button>
              </div>

            </div>

          </div>

          <div class="row">
            <div id="schedule-view" class="col-xs-8 col-xs-offset-2">

            <?php
      
                include "Schedule.php";
                //assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open, $start)
                echo (new Schedule)->assemble_overview( "07:00", 4, 7, 8, time() );                

            ?>
            </div>
          </div>
        </div>

     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="schedule.js"> </script>
  </body>
</html>


