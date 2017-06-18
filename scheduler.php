<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="schedule.css">

  </head>
  <body>

        <div class="container">

          <div class="row">

            <div class="col-xs-8 col-xs-offset-2">
              <button onclick="next_interval()"> Next interval </button>
              <button onclick="one_day_forward()"> Shift one day forward </button>
            </div>

          </div>

          <div class="row">
            <div id="schedule-view" class="col-xs-8 col-xs-offset-2">

            <?php
      
                include "Schedule.php";

                //assemble_overview($opening_hour, $hour_slice, $num_of_days, $hours_open, $start)
                $schedule = (new Schedule)->assemble_overview( "07:00", 4, 7, 5, time() );
                echo $schedule;

            ?>
            </div>
          </div>
        </div>

      <script
			src="https://code.jquery.com/jquery-3.2.1.min.js"
			integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			crossorigin="anonymous">
			</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="schedule.js"> </script>
  </body>
</html>


