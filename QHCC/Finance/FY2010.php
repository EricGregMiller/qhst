<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2010);
?>
  <h2>Overview</h2>
  <p>
    This is the 2010 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
  </p>
  <p>
    2010 was a hard year again. 
    Unemployment and under-employment struck our congregation.
    Giving dropped and we struggled.
  </p>
  <p>
    Our biggest concern is that we fell up to four months behind on our building mortgage.
    The North American Mission Board has worked with us to relieve some financial stress.
    Nonetheless, we are struggling to keep up.
    We did manage to not fall further behind the last few months of the year and even gained a little ground. 
  </p>
  <p>
    Another issue has been our payments to our pastor.
    We are three to four months behind in his business expenses.
    Several weeks we had to delay his paycheck because of lack of funds.
  </p>
  <p>
    We are also behind on our cooperative giving.
    After reinstating it a couple of years ago, we have been very good at keeping it up.
    Now we are several months behind.
  </p>
  <p>
    The are some positive signs.
    We have had some new people in church.
    In addition, the financial situation of several members has improved.
    Our parsonage air conditioning was fixed for much less money than expected.
    Child-monitoring payments from LA County have now begun.
    Finally, we have paid most of our bills -- utilities, property tax and insurance are all up-to-date.
  </p>
  <p>
    We greatly appreciate everyone's prayers and giving.
    It's not easy to stick with us through the tough times.
    Thank you for your support and let's look forward to what God will do in 2011.
  </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2010.
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
    The DSL and Temporary Funds should normally show zero balances. 
    The DSL Fund has a negative balance because Quartz Hill School of Theology is responsible for our DSL fees and is behind in reimbursing QHCC.
    The Temporary Fund covers money taken in for things not budgeted, such as Souper Bowl or the Lottie Moon offering.
  </p>
  <?php
    $fy->GenerateBalanceTable('2010Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img id="ChartBalances" src="2010 General Fund.png" alt="General Fund History">
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
    $fy->GenerateBudgetTable('2010Budget.xml');
  ?>
  <p>
    This chart shows spending compared to the budget for the major budget categories.
  </p>
  <img id="ChartBudget" src="2010 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
