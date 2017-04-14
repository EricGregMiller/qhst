<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2006);
?>
  <h2>Overview</h2>
  <p>
    This is the 2006 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
 </p>
  <p>
    The most notable and alarming trend is the loss of general funds. 
    This is especially true from July through October.
    The biggest loss occurred in July, primarily because giving was very low.
    The large expense was due to an annual insurance payment and a double mortgage payment 
    (An address error on the June payment caused it to be returned and it was re-paid in July). 
    Giving remained low until the end of September.
    At the end of August there was a large expense for termite removal from the church building.
    The high October expense is because of property tax payments.
    Giving returned to normal in October through December with perhaps a bit of a year end surge.
    This helped our General Fund recover somewhat in November and December.
 </p>
  <p>
    There are some positives to take away from 2006.
    We were able to pay off our debt to Arrow Engineering at the end of 2005 and still have a healthy General Fund balance to begin 2006.
    Another positive is that regular contributions are being made to the California Southern Baptist and High Desert Baptist coopertative programs.
    Outside of the General Fund we also made donations to the Annie Armstrong and Lottie Moon missions drives, 
    as well as to Grace Resources and to aid the Carsons trip to Mali.
  </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2006.
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
    Funds were collected throughout 2005 because the Pastor did not take distribution until February 2006.
    This is why there was a January balance of $2853.
    The non-zero balances continue throughout the year. The treasurer mistakenly thought the January balance was $1928. 
    He was off by $925. 
    In January and February he distributed the $1928 plus the normal monthly accumulation. 
    A balance above $925 remains through July because during that time the treasurer did not disburse the funds accumulated monthly until the beginning of the following month.
    From August through December the funds were distributed in the month they accumulated, so that only the mistaken $925 balance is shown.
  </p>
  <p>
    The DSL and Temporary Funds should normally show zero balances. 
    The DSL Fund has a negative balance because Quartz Hill School of Theology is responsible for our DSL fees and is behind in reimbursing QHCC.
    The Temporary Fund covers money taken in for things not budgeted, such as youth fund raisers or the Lottie Moon offering.
  </p>
  <?php
    $fy->GenerateBalanceTable('2006Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img id="ChartBalances" src="2006 General Fund.png" alt="General Fund History">
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
  <p>
    It may seem odd to see some negative spending, but it can be explained.
    The large negative for February Property Tax was a refund due to us having to overpay our first installment because we failed to file our church status on time.
    The negative Workers&apos Comp in April was also due to a refund and the negative Maintenace in May 
    was an insurance payment for water damage (we paid for the repair in April).
  </p>
  <?php
    $fy->GenerateBudgetTable('2006Budget.xml');
  ?>
  <p>
    This chart shows spending and income compared to the budget for the major budget categories.
  </p>
  <img id="ChartBudget" src="2006 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
