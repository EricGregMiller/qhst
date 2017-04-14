<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2011);
?>
  <h2>Overview</h2>
  <p>
    This is the 2011 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
  </p>
  <p>
    In 2011 our financial status greatly improved. 
    We caught up on all our bills thanks to a strong Spring and Summer.
    However most of the year was tight and giving dropped again in the last couple of months.
  </p>
  <p>
    Our biggest on-going concern the last few years has been that we struggle to make our building mortgage payment. 
    We began 2011 almost four months behind on the mortgage.
    Strong giving through the middle of the year allowed us to catch up.
    Also, the North American Mission Board agreed to extend our maturation date to October 2016.
    This reduces our payment and will allow us to keep up more easily.
  </p>
  <p>
    The good giving pattern allowed us to pay our pastor regularly and pay all his business expenses. 
    We caught up on our cooperative giving and maintained it thoughout the year.
    Utilities and the parsonage mortgage were kept up to date.
  </p>
  <p>
    Toward the end of the year giving dropped again. 
    We stuggled to pay some bills on time and especially had trouble with property tax.
    It was finally paid at the end of the year, but only after being late enough to require a 10% penalty.
    Overall 2011 was much better than 2010, but the end of year trend is cause for concern.
  </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2011.
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
    $fy->GenerateBalanceTable('2011Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img id="ChartBalances" src="2011 General Fund.png" alt="General Fund History">
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
    $fy->GenerateBudgetTable('2011Budget.xml');
  ?>
  <p>
    This chart shows spending compared to the budget for the major budget categories.
  </p>
  <img id="ChartBudget" src="2011 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
