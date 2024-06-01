<?php
session_start();

// Check if user is logged in, if not redirect to sign-in page
if (!isset($_SESSION['username'])) {
    header("Location: pages/sign-in.html");
    exit();
}

// Access username and customerid from session
$username = $_SESSION['username'];
$customerid = $_SESSION['customerid'];

// Your loan form code goes here...
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/loan-logi.png">
  <title>
    Loan Management
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>

  <style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html " target="_blank">
        <img src="../assets/img/loan-logi.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Loan Management</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link  " href="../pages/userdash.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>shop </title>
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                    <g transform="translate(1716.000000, 291.000000)">
                      <g transform="translate(0.000000, 148.000000)">
                        <path class="color-background opacity-6" d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                        <path class="color-background" d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  active" href="../pages/loanform.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>office</title>
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF" fill-rule="nonzero">
                    <g transform="translate(1716.000000, 291.000000)">
                      <g id="office" transform="translate(153.000000, 2.000000)">
                        <path class="color-background opacity-6" d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"></path>
                        <path class="color-background" d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z"></path>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
            </div>
            <span class="nav-link-text ms-1">Loan Form</span>
          </a>
        </li> 
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Loan Form</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Loan Form</h6>
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row justify-content-center align-items-center" >
        <div class="col-lg-8 mb-lg-0 mb-4">
            <div class="card mb-4"> 
                <div class="card-body p-3">
                  <form id="loan-form">
                  <?php
        // Assuming session_start() has been called before this point to start the session.

        // Include your database connection file
        include '../dbconnect.php'; // Update the filename as per your actual file name

        // Retrieve user_id from session
        $user_id = $_SESSION['customerid'];

        // Prepare and execute query to fetch user data
        $query = "SELECT * FROM customers WHERE CustomerID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $customerid); // Assuming user_id is an integer
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user data is found
        if ($result->num_rows > 0) {
            // Fetch user data and populate form fields
            $row = $result->fetch_assoc();
            $name = $row['FirstName'];
            $gender = $row['Gender'];
            $married = $row['Married'];
            $education = $row['Education'];
            $dependents = $row['Dependents'];
            $applicantIncome = $row['ApplicantIncome'];
            $coapplicantIncome = $row['CoapplicantIncome'];
            $creditHistory = $row['CreditHistory'];
            $propertyArea = $row['PropertyArea'];
            $selfEmployed = $row['selfEmployed'];
        } else {
            // Handle case where user data is not found
            // You can redirect to an error page or perform other actions here
        }

        // Close prepared statement and database connection
        $stmt->close();
        $conn->close();
        ?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="label" for="nama">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="gender">Gender</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="married">Married</label>
                    <select class="form-control" id="married" name="married">
                        <option value="Yes" <?php if ($married == 'Yes') echo 'selected'; ?>>Yes</option>
                        <option value="No" <?php if ($married == 'No') echo 'selected'; ?>>No</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="Dependents">Dependents</label>
                    <select class="form-control" id="Dependents" name="Dependents">
                        <option value="0" <?php if ($dependents == '0') echo 'selected'; ?>>0</option>
                        <option value="1" <?php if ($dependents == '1') echo 'selected'; ?>>1</option>
                        <option value="3+" <?php if ($dependents == '3+') echo 'selected'; ?>>3+</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="Property">Property Area</label>
                    <select class="form-control" id="Property" name="Property">
                        <option value="Urban" <?php if ($propertyArea == 'Urban') echo 'selected'; ?>>Urban</option>
                        <option value="SemiUrban" <?php if ($propertyArea == 'SemiUrban') echo 'selected'; ?>>Semi Urban</option>
                        <option value="Rural" <?php if ($propertyArea == 'Rural') echo 'selected'; ?>>Rural</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="Education">Education</label>
                    <select class="form-control" id="Education" name="Education">
                        <option value="Graduate" <?php if ($education == 'Graduate') echo 'selected'; ?>>Graduate</option>
                        <option value="Not Graduate" <?php if ($education == 'Not Graduate') echo 'selected'; ?>>Not Graduate</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="selfemployed">Self Employed</label>
                    <select class="form-control" id="selfemployed" name="selfemployed">
                        <option value="Yes" <?php if ($selfEmployed == 'Yes') echo 'selected'; ?>>Yes</option>
                        <option value="No" <?php if ($selfEmployed == 'No') echo 'selected'; ?>>No</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="label" for="ApplicantIncome">Applicant Income</label>
            <input type="number" min="0" pattern="\d*" class="form-control" id="ApplicantIncome" name="ApplicantIncome" value="<?php echo $applicantIncome; ?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="label" for="coApplicantIncome">Co Applicant Income</label>
            <input type="number" min="0" pattern="\d*" class="form-control" id="coApplicantIncome" name="coApplicantIncome" value="<?php echo $coapplicantIncome; ?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="label" for="LoanAmount">Loan Amount</label>
            <input type="number" min="0" pattern="\d*" class="form-control" id="LoanAmount" name="LoanAmount">
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="LoanTime">Length Time</label>
                    <input type="number" min="0" pattern="\d*" class="form-control" id="LoanTime" name="LoanTime">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="label" for="CreditHistory">Credit History</label>
                    <select class="form-control" id="CreditHistory" name="CreditHistory">
                        <option value="1" <?php if ($creditHistory == '1') echo 'selected'; ?>>Yes</option>
                        <option value="0" <?php if ($creditHistory == '0') echo 'selected'; ?>>No</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary submit p-3" onclick="submitForm(event)">Submit Form</button>
                            </div>
                        </div>                                       
                    </div>
                </form>
              </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="predictionModal" tabindex="-1" role="dialog" aria-labelledby="predictionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="predictionModalLabel">Loan Prediction Result</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <p>Prediction Result: <span id="predictionResult"></span></p>
                <p>Current Date: <span id="currentDate"></span></p>
                <p>Due Date: <span id="dueDate"></span></p>
                <p>Loan Amount: <span id="loanAmount"></span></p>
                <p>Interest Amount: <span id="InterestAmount"></span></p>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="test()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitFormDataAndSendToSQL()">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"> </script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script type="text/javascript" src="../js/jquery.min.js"></script>

  <script>
  function test() {
    $('#predictionModal').modal('hide');
  }

  function submitForm(event) {  
    var form = document.getElementById("loan-form");
    var formData = new FormData(form);

    // Prevent default form submission behavior
    event.preventDefault();

    // Send form data to Flask backend using AJAX
    fetch('http://127.0.0.1:5000/predict', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch prediction data');
        }
        return response.json(); 
    })
    .then(data => {
        console.log('Prediction data:', data);
        for (let pair of formData.entries()) {
          console.log(pair[0] + ': ' + pair[1]);
        }
        // Display prediction result
        var prediction = data.prediction;
        console.log('Prediction:', prediction);
        var predictionText = prediction === 0 ? "Rejeected" : "Approved";

        // Calculate time from now to due date
        var loanTime = document.getElementById('LoanTime').value; // Get loan time in months
        var currentDate = new Date(); // Get current date
        var dueDate = new Date(currentDate.getTime() + (loanTime * 24 * 60 * 60 * 1000)); // Calculate due date
        var interest = 5;
        // Format due date
        var formattedCurrentDate = currentDate.toISOString().slice(0,10); // Format current date
        var formattedDueDate = dueDate.toISOString().slice(0,10); // Format due date
        document.getElementById('predictionResult').textContent = predictionText;
        document.getElementById('currentDate').textContent = formattedCurrentDate;
        document.getElementById('dueDate').textContent = formattedDueDate;
        var loanAmountValue = formData.get('LoanAmount');
        document.getElementById('loanAmount').textContent = loanAmountValue;
        document.getElementById('InterestAmount').textContent = interest;

        // Show the modal        
        $('#predictionModal').modal('show');
    })
    .catch(error => {
        console.error('Error:', error);
        // Show an alert or handle the error appropriately
    });
  }

  function submitFormDataAndSendToSQL() {
    var form = document.getElementById("loan-form");
    var formData = new FormData(form);
    submitFormData(formData);
  }

  function submitFormData(formData) {
    var prediction = document.getElementById('predictionResult').textContent;

    // Send the form data to the server using AJAX
    formData.append('Loan_Status', prediction);

    fetch('../loanapp.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to save data to database');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                // Handle successful response
                console.log('Data saved to database successfully');
                // Assuming you have the loan ID available in the response
                var loanID = data.id;
                var amount = formData.get("LoanAmount");
                var interestRate = 5; // Assuming a fixed interest rate of 5%
                var startDate = document.getElementById("currentDate").textContent;
                var endDate = document.getElementById("dueDate").textContent;
                var status = prediction;
                console.log("Loan ID:", loanID);
        console.log("Amount:", amount);
        console.log("Interest Rate:", interestRate);
        console.log("Start Date:", startDate);
        console.log("End Date:", endDate);
        console.log("Status:", status);

                sendDataToSQL(formData, loanID, amount, interestRate, startDate, endDate, status);
            } else {
                // Handle error response
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            // Handle fetch error
            console.error('Fetch Error:', error);
        });

        fetch('../update.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to save data to database');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                // Handle successful response
                console.log('Data saved to database successfully');
            } else {
                // Handle error response
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            // Handle fetch error
            console.error('Fetch Error:', error);
        });
  }

  function sendDataToSQL(formData, loanID, amount, interestRate, startDate, endDate, status) {
    // Construct the FormData object
    var formData = new FormData();
    formData.append('LoanID', loanID);
    formData.append('Amount', amount);
    formData.append('InterestRate', interestRate);
    formData.append('StartDate', startDate);
    formData.append('EndDate', endDate);
    formData.append('Status', status);

    // Send the data to the server-side script using fetch
    fetch('../sendtoloan.php', {
      method: 'POST',
        body: formData // Pass the FormData object here
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to save data to database');
        }
        return response.json(); // Parse the JSON response
    })
    .then(responseData => {
        // Check if there's an error message in the response
        if (responseData.error) {
            console.error('Error:', responseData.error);
            // Display the error message to the user or handle it appropriately
        } else if (responseData.success) {
            console.log('Success:', responseData.success);
            // Display a success message to the user or handle it appropriately
        } else {
            console.error('Unexpected response:', responseData);
            // Handle unexpected responses
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show an alert or handle the error appropriately
    });
}

</script>

    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>