<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2013);
?>
  <h2>Overview</h2>
  <p>
    This is the 2013 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
  </p>
  <p>
    At the end of 2012 we saw encouraging signs of financial stability after several difficult years.
    2013 built on this stability. 
    January showed negative cash flow and we ended up with a very negative <span style="color:red;font-weight:bold">-$1,084</span> General Fund balance.
    However, from February through July we maintained a constantly positive cash flow.
    This consistency allowed us to climb to a positive $1,247 General Fund balance at the end of July.
    August through December were more variable, with net cash flow over these months near even.
    We ended December with a reasonable $1,100 General Fund balance.
    Throughout the year we paid our bills on time.
  </p>
  <p>
    In addition to our General Fund, we reached out financially in many ways.
    We gave $400 to a new church in Mojave.
    We also sent $826 to the High Desert and California Southern Baptist cooperative funds.
    On a more personal level we gave $120 of Deacons' Fund money to the needy in our community.
  </p>
  <p>
    Looking ahead we can hope and pray for continued financial stability and perhaps even growth.
    We are on track to pay off our building mortgage at the end of 2016.
    Despite continued economic hardship we have reason to be encouraged in the generosity of our members and of the God whom we serve.
  </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2013.
    The chart below the table shows the General Fund history.
    The chart includes unpaid bills in the General Fund balance to show when we are behind.
    All funds are contained in the QHCC Account, which means that the QHCC Account column is a total of the rest.
    Most income and spending occurs through the General Fund.
<!--    When we fall behind in our bills, another bar appears on the chart.
    The "Effective Balance" bars show the General Fund minus any outstanding bills. -->
  </p>
  <p>
    The Parsonage Fund has funds primarily from parsonage refinancing and is used to care for and maintain the parsonage.
    The Deacon Fund is usually donated to every communion service and is used to help people in need.
    At the 2008 budget meeting we voted to set up the Holding Fund.
    It is designed to hold funds needed to pay irregular large bills such as the property tax.
    Currently we are behind in our bills so the Holding Fund has no money.
    Periodically youth at the church raise money and this money is stored in the Youth Fund.
  </p>
  <p>
    The Internet and Temporary Funds should normally show zero balances. 
    The Internet Fund tracks Quartz Hill School of Theology's support for our internet fees.
    The Temporary Fund covers money taken in for things not budgeted, such as Souper Bowl or the Lottie Moon offering.
  </p>
  <?php
    $fy->GenerateBalanceTable('2013Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img id="ChartBalances" src="2013 General Fund.png" alt="General Fund History">
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
    $fy->GenerateBudgetTable('2013Budget.xml');
  ?>
  <p>
    This chart shows spending compared to the budget for the major budget categories.
  </p>
  <img id="ChartBudget" src="2013 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
