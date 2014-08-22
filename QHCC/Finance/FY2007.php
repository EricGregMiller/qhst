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
  <p>
    After losing most of our General Fund balance in 2006, we stabilized at the end of 2006 and the early part of 2007. 
    In May 2007 a large gift raised our balance to near $6,000.
    As usual summer was bad and we crashed all the way to zero by the end of August. 
    We rebounded slightly in September but went back to zero in October. 
    Starting in October we were continually behind in our bills and never experienced our normal year-end surge. 
    We did manage to end 2007 with all bills paid, but only barely. 
    We ended the year with $451 in the General Fund which was not enough to pay the bills due the first week of 2008.
 </p>
  <p>
    Because our financial situation was critical the treasurer began making weekly reports to the deacons and then to the congregation. 
    During this time our giving did become more consistent which is a big reason we survived the end of the year. 
    Weekly reports will continue as long as we are behind on our bills.
    However, now the reports are made by email only to members.
    Monthly status updates will be given to the congregation as announcement slides.
 </p>
  <p>
    Despite the problems with our General Fund we were able to fix our roof. 
    The congregation raised over $10,000 for the roof, most of it during the summer.
    It was a much needed fix and is really appreciated now that the winter rains have set in.
    No doubt the great generosity shown toward the roof fund limited our capacity to give to the General Fund at the end of 2007.
 </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2007.
    The chart below the table shows the General Fund history.
    All funds are contained in the QHCC Account, which means that the QHCC Account column is a total of the rest.
    Most income and spending occurs through the General Fund.
    When we fall behind in our bills, another line appears on the chart.
    The "Effective Balance" lines shows the General Fund minus any outstanding bills. 
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
    The Temporary Fund covers money taken in for things not budgeted, such as youth fund raisers or the Lottie Moon offering. The $75 balance are funds the youth raised but have not used yet.
  </p>
  <?php
    $fy->GenerateBalanceTable('2007Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img id="ChartBalances" src="2007 General Fund.png" alt="General Fund History">
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
  <img id="ChartBudget" src="2007 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
