<div class = "card" id = "north">
      <div class = "contain">
        <div class = "buttons">
          <span class = "btn" id = "button0" onclick = "plotGraph('yeardata.php', 0, 'north')">year</span> 
          <span class = "btn" id = "button1" onclick = "plotGraph('monthdata.php', 1, 'north')">month</span> 
          <span class = "btn" id = "button2" onclick = "plotGraph('weekdata.php', 2, 'north')">day</span> 
          <!--span class = "btn" id = "button3" onclick = "changeGraph('yeardata.php', 3)">day</span--> 
        </div>
        <div class = "svg" id = "northsvg">
        <svg class = "graph" id = "northgraph"></svg>
        </div>
        <script src = "scripts/graph.js"></script>
        <script>
          /** Only function needs to be called to generate graph
            First parameter is the php file to call to database and get data
            Second parameter is the mode such as year month or week, 0 for year, 1 for month, 2 for week
            Scales are still not working will be fixed
            Functions for second line graph is still not done
          */
          plotGraph("monthdata.php",1, "north");
        </script>
        <div id = "notifs">
          <h1>[Insert whatever title needed for this section]</h1>
          <div>[Insert whatever needs to be displayed here]</div>
        
        </div>
      </div>
    </div>