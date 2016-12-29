<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2007);
?>
  <h2>Overview</h2>
  <p>
    This is the 2007 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
 </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2007.
    The chart below the table shows the General Fund history.
    All funds are contained in the QHCC Account, which means that the QHCC Account column is a total of the rest.
    Most income and spending occurs through the General Fund.
  </p>
  <p>
    The Parsonage Fund has funds primarily from parsonage refinancing and is used to care for and maintain the parsonage.
    The Deacon Fund is usually donated to every communion service and is used to help people in need.
    To help with upkeep and improvement of the church property, the Restore Fund was started.
    It receives irregular donations and also is spent sporadically.
  </p>
  <p>
    The Pastor Retirement Fund was started to aid our pastor in saving for retirement. 
    Most money for it comes out of the General Fund, although contributions are welcome.
    Usually any funds accumulated are distributed to the pastor at the end of the month, so that the reported balance should be zero.
    However, we began the year with a balance of $925.
    This was due to a treasurer mistake explained in the <a href="FY2006.php">2006</a> report.
    The February distribution was not made until early March, so February shows a balance above $925.
  </p>
  <p>
    The DSL and Temporary Funds should normally show zero balances. 
    The DSL Fund has a negative balance because Quartz Hill School of Theology is responsible for our DSL fees and is behind in reimbursing QHCC.
    The Temporary Fund covers money taken in for things not budgeted, such as youth fund raisers or the Lottie Moon offering.
  </p>
  <?php
    $fy->GenerateBalanceTable('2007Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img src="2007 General Fund.png" alt="General Fund History">
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
  <?php
    $fy->GenerateBudgetTable('2007Budget.xml');
  ?>
  <p>
    This chart shows spending and income compared to the budget for the major budget categories.
  </p>
  <img src="2007 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
