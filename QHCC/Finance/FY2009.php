<?php
  require 'FY.php';
  $fy = new FY;
  $fy->FYHead(2009);
?>
  <h2>Overview</h2>
  <p>
    This is the 2009 financial report for Quartz Hill Community Church.
    It starts with this overview of the year.
    Following the overview there is detailed information about fund balances and the budget. 
  </p>
  <p>
    2009 was a good year financially. 
    The strong giving at the end of 2008 continued through the early part of 2009.
    Spring giving was especially strong. 
    It allowed us to fully catch up on our bills and even begin a holding fund for irregular expenses.
    (The membership voted this through long ago, but we finally had the money to implement it.)
  <p>
  </p>
    Giving was typically down a bit in the summer, but our holding fund got us through.
    In the fall giving went up enough to keep us current on our bills.
    The charts show that November was a huge giving month, but this is a bit misleading.
    One member gave a large amount but probably won't be able to give much for the next six to eight months.
    For this reason we started a holding fund with most of the large November gift.
    The plan is to take money from the holding fund as needed, hopefully stretching over the expected shortfall months.
  </p>
  <p>
    Our mortgage situation was especially satisfying.
    We caught up on our building mortgage payments that for so long had been behind.
    Now we are back to normal payments and are scheduled to pay it off in just over four years, around March 2014.
  </p>
  <p>
    We also were able to refinance our parsonage mortgage.
    It is a five-year loan with a balloon payment due at the maturity date.
    Our usual procedure is to extend it another five years when the balloon is due.
    Antelope Valley Bank (now California Bank and Trust) came through again with an extension in March.
    The new maturity date is March 2014, about the same time we should pay off our building mortgage.
    That will make it easier renew the loan and free up money to pay it down.
  </p>
  <p>
    One area of concern is the parsonage.
    We were able to put in a new central heating unit.
    However, the parsonage fund is now down to $936.
    Furthermore, the air conditioning doesn't work and needs to be replaced before summer.
    Getting a new or increased loan on the parsonage seems like a bad idea and is probably not possible.
    We need to be prepared in the next four years to stretch the remaining money and rely on gifts to make the necessary parsonage repairs.
    After that our building mortgage will be paid off and we should have more funds available for parsonage repair. 
  </p>
  <p>
    Yes, there are some concerns, but overall we can praise God for his goodness.
    During these tough economic times we have not only survived but are actually better off than we were a year and a half ago.
    Our deacon fund has increased and is available as needs arise.
    We helped the Scott family through their time of crisis.
    Your giving is the reason we could do all of this -- thank you.
    Let's look forward to the good God will do in 2010.
  </p>
  <h2>Balances</h2>
  <p>
    The table below shows the balances of the various QHCC funds at the end of each month in 2009.
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
    $fy->GenerateBalanceTable('2009Balances.xml');
  ?>
  <p>
    Here is the chart showing the General Fund balances, income and expenses throughout the year.
  </p>
  <img id="ChartBalances" src="2009 General Fund.png" alt="General Fund History">
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
    $fy->GenerateBudgetTable('2009Budget.xml');
  ?>
  <p>
    This chart shows spending compared to the budget for the major budget categories.
  </p>
  <img id="ChartBudget" src="2009 Budget.png" alt="Actual vs Budget">
  <?php
    $fy->PageEnd();
  ?>
</body>
</html>
