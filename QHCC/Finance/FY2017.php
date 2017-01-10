<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2017);
?>
  <h2>Overview</h2>
  <p>
    This is the 2017 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
  </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2017.
    The chart below the table shows the General Fund history.
    The chart includes unpaid bills in the General Fund balance to show when we are behind.
    All funds are contained in the QHCC Account, which means that the QHCC Account column is a total of the rest.
    Most income and spending occurs through the General Fund.
<!--    When we fall behind in our bills, another bar appears on the chart.
    The "Effective Balance" bars show the General Fund minus any outstanding bills. -->
  </p>
  <p>
    The Parsonage Fund has funds from the parsonage sale. 
		It is being held in reserve to support future pastor housing needs.
    A formal offering for the Deacon Fund is taken in every communion service but can be donated to at any time.
		It is used to help people in need at the discretion of the deacons.
    The Holding Fund is designed to hold funds needed to pay irregular large bills such as the property tax.
    Periodically youth at the church raise money and this money is stored in the Youth Fund.
  </p>
  <p>
    The Temporary Fund should normally show zero balance. 
    The Temporary Fund covers money taken in for things not budgeted, such as a sudden need, a special offering, or a short-term project.
  </p>
  <iframe src="https://docs.google.com/spreadsheets/d/1ATZspapc1WFodez8hGV8MicE5SmQCCfO0I0WH0rPTyY/pubhtml?gid=625249806&amp;single=true&amp;widget=true&amp;headers=false&amp;range=A2%3AK15" width="830" height="325"></iframe>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <iframe src="https://docs.google.com/spreadsheets/d/1ATZspapc1WFodez8hGV8MicE5SmQCCfO0I0WH0rPTyY/pubchart?oid=980390974&amp;format=interactive" width="600" height="375"></iframe>
  <h2>Budget</h2>
  <p>
    This table shows the how income and spending compare with the budget throughout the year.
    The left-hand column shows the budget categories and sub-categories.
    Next to it the Budget Column shows the monlthy budgeted amounts for each category.
    The next columns show the income and spending for each month.
    The Total YTD Column shows the total income and spending for the year to date.
    The Budget YTD Column shows the amount budgeted for the year to date.
    The Difference Column shows the difference between actual income and spending and the budget for the year to date.
    The Annual Budget Column shows the yearly budget amounts.
  </p>
  <iframe src="https://docs.google.com/spreadsheets/d/1eH-x7bvPB_2jLElMZArP1GKkc1jG5UiBV_UqAtqMv5k/pubhtml?gid=1991634472&amp;single=true&amp;widget=true&amp;headers=false&amp;range=A4%3AR49" width="1500" height="900"></iframe>
  <p>
    This chart shows spending compared to the budget for the major budget categories.
  </p>
  <iframe src="https://docs.google.com/spreadsheets/d/1eH-x7bvPB_2jLElMZArP1GKkc1jG5UiBV_UqAtqMv5k/pubchart?oid=1194222153&amp;format=interactive" width="600" height="375"></iframe>
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>

