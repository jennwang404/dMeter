	<div class = "card" id = "south">
      <div class = "contain">
        <div class = "buttons">
          <span class = "btn" id = "button0" onclick = "plotGraph('yeardata.php?secondGraph=Temperature', 0, 'south')">year</span> 
          <span class = "btn" id = "button1" onclick = "plotGraph('monthdata.php?secondGraph=Temperature', 1, 'south')">month</span> 
          <span class = "btn" id = "button2" onclick = "plotGraph('weekdata.php?secondGraph=Temperature', 2, 'south')">day</span> 
          <!--span class = "btn" id = "button3" onclick = "changeGraph('yeardata.php', 3)">day</span--> 
        </div>
        <div class = "svg" id = "southsvg">
        <svg class = "graph" id = "southgraph"></svg>
        </div>
        <script src = "scripts/graph.js"></script>
        <script>
          /** Only function needs to be called to generate graph
            First parameter is the php file to call to database and get data
            Second parameter is the mode such as year month or week, 0 for year, 1 for month, 2 for week
            Scales are still not working will be fixed
            Functions for second line graph is still not done
          */
          plotGraph("monthdata.php?secondGraph=Temperature",1, "south");
        </script>
        <div id = "notifs">
          <h1>Money saved this <span id="period"></span> in comparison to last:</h1>
          <?php
            //Get the connection info for the database
            require_once 'includes/config.php';

            //Establish a database connection
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            //Was there an error connecting to the database?
            if ($mysqli->errno) {
              //The page isn't worth much without a db connection so display the error and quit
              print($mysqli->error);
              exit();
            }

            //The current year (ex. 2016)
            $year_query1 = "SELECT SUM(Money) FROM Money_Uses WHERE Day LIKE '2016%'";
            //Last year (ex. 2015)
            $year_query2 = "SELECT SUM(Money) FROM Money_Uses WHERE Day LIKE '2015%';";

            $year_result1 = $mysqli->query($year_query1);
            $year_result2 = $mysqli->query($year_query2);

            if ($year_result1 && $year_result2) {
              $row1 = $year_result1->fetch_assoc();
              $row2 = $year_result2->fetch_assoc();
              $year_amt = $row2['SUM(Money)'] - $row1['SUM(Money)'];
            }

            //The current month (ex. July 2016)
            $month_query1 = "SELECT SUM(Money) FROM Money_Uses WHERE Day LIKE '2016-07%'";
            //Last month (ex. June 2016)
            $month_query2 = "SELECT SUM(Money) FROM Money_Uses WHERE Day LIKE '2016-06%';";

            $month_result1 = $mysqli->query($month_query1);
            $month_result2 = $mysqli->query($month_query2);

            if ($month_result1 && $month_result2) {
              $row1 = $month_result1->fetch_assoc();
              $row2 = $month_result2->fetch_assoc();
              $month_amt = $row2['SUM(Money)'] - $row1['SUM(Money)'];
            }

            //The current day (ex. July 30th 2016)
            $day_query1 = "SELECT SUM(Money) FROM Money_Uses WHERE Day = '2016-07-30'";
            //Yesterday (ex. July 29th 2016)
            $day_query2 = "SELECT SUM(Money) FROM Money_Uses WHERE Day = '2016-07-29';";

            $day_result1 = $mysqli->query($day_query1);
            $day_result2 = $mysqli->query($day_query2);

            if ($day_result1 && $day_result2) {
              $row1 = $day_result1->fetch_assoc();
              $row2 = $day_result2->fetch_assoc();
              $day_amt = $row2['SUM(Money)'] - $row1['SUM(Money)'];
            }

            echo '<span id="year_saved">$'.$year_amt.'</span>';
            echo '<span id="month_saved">$'.$month_amt.'</span>';
            echo '<span id="day_saved">$'.$day_amt.'</span>';
          ?>
        </div>
      </div>
    </div>