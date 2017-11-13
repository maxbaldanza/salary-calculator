Feature: Export salary

  Scenario: Export command does not require arguments
    When I run "salary:export" command
    Then I should see "Output wrote to file: var/payroll.csv"

  Scenario: Export salaries
    Given the date is '2017-11-08'
    And the filename is 'var/test-payroll.csv'
    When I run "salary:export" command
    Then I should see "Output wrote to file: var/test-payroll.csv"
    And the file "var/test-payroll.csv" should contain:
    """
    Month,Bonus,Salary
    12/2017,15-01-2018,31-01-2018
    01/2018,15-02-2018,28-02-2018
    02/2018,15-03-2018,30-03-2018
    03/2018,18-04-2018,30-04-2018
    04/2018,15-05-2018,31-05-2018
    05/2018,15-06-2018,29-06-2018
    06/2018,18-07-2018,31-07-2018
    07/2018,15-08-2018,31-08-2018
    08/2018,19-09-2018,28-09-2018
    09/2018,15-10-2018,31-10-2018
    10/2018,15-11-2018,30-11-2018
    11/2018,19-12-2018,31-12-2018
    """
