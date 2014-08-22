<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2012);
?>
  <h2>Overview</h2>
  <p>
    This is the 2012 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
  </p>
  <p>
    Our 2012 financial history is probably best characterized by greater financial stability. 
    After catching up in 2011 we started 2012 near even.
    As usual we had our ups and downs.
    However, we generally kept up with our bills.
    Near the end of the year we lost a little with giving a bit down and property taxes to pay.
    Giving improved a bit in December and we recovered to pay all our bills by year end.
    We ended up with a slightly negative General Fund balance of <span style="color:red;font-weight:bold">-$358</span>.
    Overall, though we ended with our bills paid and money in the bank.
  </p>
  <p>
    Our biggest on-going concern the last few years has been that we struggle to make our building mortgage payment. 
    In 2011 the North American Mission Board agreed to extend our maturation date and lower our payment.
    As a result we did much better in 2012, only falling behind late in November when we also had to pay property tax.
  </p>
  <p>
    The stability in our giving allowed us to pay our pastor and our bills regularly. 
    Looking forward this kind of stable pattern is encouraging.
  </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2012.
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
    $fy->GenerateBalanceTable('2012Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img id="ChartBalances" src="2012 General Fund.png" alt="General Fund History">
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
    $fy->GenerateBudgetTable('2012Budget.xml');
  ?>
  <p>
    This chart shows spending compared to the budget for the major budget categories.
  </p>
  <img id="ChartBudget" src="2012 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
