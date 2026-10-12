\# Quality Assurance Toolkit (QAT) - Wish Note Web Application



\## Repository Overview



This repository contains a Quality Assurance \& Testing (QAT) toolkit designed for evaluating an AI-generated PHP web application connected to a MariaDB database server.



\### Repository Contents



\* \*\*Part A:\*\* `readme.md` - Documentation and test execution details for the target AI-generated application.

\* \*\*Part B:\*\* `webapp-generation-prompt.txt` - The prompt specification used to generate the application codebase.

\* \*\*Part C:\*\* `test-webapp.php` - The target single-file PHP application featuring front-end validation and backend persistence logic.



\---



\## Test Case Documentation



\### General Information



\* \*\*Test Case ID:\*\* TC-DataEntry-001

\* \*\*Test Case Title:\*\* Data Entry - Valid

\* \*\*Test Case Description:\*\* Functional Testing of Data Entry page with Backend validation using MySQL queries.

\* \*\*Preconditions:\*\* Kara David Birthday Wishnote App is installed locally and MySQL database is pre-populated for comparison. Data entry page is accessed in latest Chrome/Firefox browser.

\* \*\*Source Reference:\*\* `textcase.txt`



\---



\### Execution Table



| Step | Action | Expected Result | Actual Result |

| :--- | :--- | :--- | :--- |

| \*\*a\*\* | Verify that the form contains labels in proper order and the text boxes are writable | The form contains labels in this order: "Target's First Name", "Target's Last Name", "Target's Government Position", and "Target's Location"; all text boxes are writable | The form contains labels in this order: "Target's First Name", "Target's Last Name", "Target's Government Position", and "Target's Location"; all text boxes are writable |

| \*\*b\*\* | Verify the "Send Wish Note" button. | The "Send Wish Note" button changes color on hover and is not disabled | The "Send Wish Note" button changes color on hover and is not disabled |

| \*\*c\*\* | Enter test data on their respective fields | The respective fields accept data entries of valid test data. | The respective fields accept data entries of valid test data. |

| \*\*d\*\* | On clicking of "Send Wish Note" button, a modal will appear. | Pending Execution | Pending Execution |

| \*\*e\*\* | Verify if the modal contains the same entry as your test data | Pending Execution | Pending Execution |

| \*\*f\*\* | Click the Cancel button | Pending Execution | Pending Execution |

| \*\*g\*\* | Click again on "Send Wish Note" button, and click on "Confirm and Send" button in the modal box. | Pending Execution | Pending Execution |

| \*\*h\*\* | Verify if a successful entry message shows in the Data Entry page. | Pending Execution | Pending Execution |

| \*\*i\*\* | Verify the test data if it shows in the database. | Pending Execution | Pending Execution |

