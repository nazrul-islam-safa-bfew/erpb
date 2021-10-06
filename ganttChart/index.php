<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
     <div id="chart_div"></div> 
  
  
  <script type="text/javascript">
  
   google.charts.load('current', {'packages':['gantt']});
   google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task Code');
      data.addColumn('string', 'Description');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        ['2014Spring', 'Spring 2014', 'spring',
         new Date(2014, 2, 22), new Date(2014, 5, 20), null, 100, null],
        ['2014Summer', 'Summer 2014', 'summer',
         new Date(2014, 5, 21), new Date(2014, 8, 20), null, 100, null],
        ['2014Autumn', 'Autumn 2014', 'autumn',
         new Date(2014, 8, 21), new Date(2014, 11, 20), null, 100, null],
        ['2015Spring', 'Spring 2015', 'spring',
         new Date(2015, 3, 22), new Date(2015, 6, 30), null, 50, null],
        ['2014Winter', 'Winter 2014', 'winter',
         new Date(2014, 11, 21), new Date(2015, 2, 21), null, 100, null],
      ]);

      var options = {
        width: 1000,
        height: 500,
        gantt: {
          trackHeight: 30
        },
        gantt:{
          labelStyle: {
            color: '#000'
          },
          innerGridTrack: {fill: '#fff3e0'},
          innerGridDarkTrack: {fill: '#ffcc80'}
        }
   
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }

  </script>
</body>
</html>