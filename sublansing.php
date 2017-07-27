	<div class = "card" id = "lansing" >
      <div class = "contain">
        <div class = "buttons">
          <span class = "btn" id = "button0" onclick = "plotGraph('yeardata.php?secondGraph=Temperature', 0, 'lansing')">year</span> 
          <span class = "btn" id = "button1" onclick = "plotGraph('monthdata.php?secondGraph=Temperature', 1, 'lansing')">month</span> 
          <span class = "btn" id = "button2" onclick = "plotGraph('weekdata.php?secondGraph=Temperature', 2, 'lansing')">day</span> 
          <!--span class = "btn" id = "button3" onclick = "changeGraph('yeardata.php', 3)">day</span--> 
        </div>
        <div class = "svg" id = "lansingsvg">
        <svg class = "graph" id = "lansinggraph"></svg>
        </div>
        <script src = "scripts/graph.js"></script>
        <script>
          /** Only function needs to be called to generate graph
            First parameter is the php file to call to database and get data
            Second parameter is the mode such as year month or week, 0 for year, 1 for month, 2 for week
            Scales are still not working will be fixed
            Functions for second line graph is still not done
          */
          plotGraph("monthdata.php?secondGraph=Temperature",1, "lansing");
        </script>
        <div id = "notifs">
          <h1>[Insert whatever title needed for this section]</h1>
          <div>[Insert whatever needs to be displayed here]</div>
        
        </div>
      </div>