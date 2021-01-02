<?php
// Initialize the session
session_start();
include("config.php");
include("statistics.php");
$_SESSION['timestamp'] = time();

 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

if(time() - $_SESSION['timestamp'] > 900) { 
    header("Location: logout.php"); 
    exit;
} else {
    $_SESSION['timestamp'] = time(); 
}




$sql = "SELECT username, password FROM login";
$result = $link->query($sql);



$budgetcalc = "SELECT id, username, cost FROM expenses";
$budgetresult = $link->query($budgetcalc);
$totalspent = 0;

if($budgetresult->num_rows > 0){
    while($row = $budgetresult->fetch_assoc()){
        if($row['username'] == $_SESSION['username']){
            $totalspent += $row['cost'];
        }
    }
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Dhingra Financial Tracker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/Chart.min.css">
    <meta http-equiv="refresh" content="900;url=logout.php" />
    <script src='dist/Chart.js'></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 px-1 bg-primary min-vh-100">
                <div class="py-2 sticky-top flex-grow-1">
                    <div class="nav flex-sm-column">
                        <p class='text-light'>Logged in as: <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
                        <?php
                            $sql = "SELECT username, budget FROM settings";
                            $results = $link->query($sql);
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    if($row['username'] == $_SESSION['username']){
                                        if($row['budget'] == 0){
                                            echo "<button class='btn btn-danger m-3'><a href='personalbudget.php' class='nav-link text-dark'>UPDATE SETTINGS</a></button>";
                                        } else {
                                            echo "<button class='btn btn-light m-3'><a href='personalbudget.php' class='nav-link text-dark'>Update Settings</a></button>";
                                        }
                                    }
                                }
                            }
                            
                        ?>
                        <button class='btn btn-light m-3'><a href="add_expense.php" class="nav-link text-dark">Add Expense</a></button>
                        <button class='btn btn-light m-3'><a href="personalexpenses.php" class="nav-link text-dark">View Personal Expenses</a></button>
                        <button class='btn btn-light m-3'><a href="totalexpenses.php" class="nav-link text-dark">View Family Expenses</a></button>
                        <button class='btn btn-light m-3'><a href="deleteexpense.php" class="nav-link text-dark">Delete Expense</a></button>
                        <button class='btn btn-light m-3'><a href="createcategory.php" class="nav-link text-dark">Create New Category</a></button>
                        <button class='btn btn-light m-3'><a href="editcategory.php" class="nav-link text-dark">Edit Category</a></button>
                        <button class='btn btn-light m-3'><a href="reset-password.php" class="nav-link text-dark">Reset Password</a></button>
                        <button class='btn btn-light m-3'><a href="logout.php" class="nav-link text-dark  ">Log Out of your Account</a></button>
                    </div>
                </div>
            </div>
            <div class="col" id="main">
                <h3 class='display-3'>Dhingra Financial Tracker <span class="badge badge-success"><?php echo htmlspecialchars($_SESSION["username"]); ?></span></h1> 
                
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-6'>
                        <h1 class='display4'>Personal Statistics</h1>

                        <?php
                        //returns current month
                        //displaying personal statistics 
                        $sql = "SELECT username, budget FROM settings";
                        $username = $_SESSION['username'];
                        $monthlyBudget;
                        $results = $link->query($sql);
                        if($results->num_rows > 0){
                            while($row = $results->fetch_assoc()){
                                if($_SESSION['username'] == $row['username']){
                                    if($row['budget'] != 0){
                                        $monthlyBudget = $row['budget'];
                                        echo "<p>Monthly Budget: " . $row['budget'] . "</p>";
                                    } else {
                                        echo "<p>Edit Monthly Budget by clicking Edit Settings. </p>";
                                        $monthlyBudget = 0;
                                    }
                                }
                            }
                        }

                        echo "<p>Total Spent This Month (Personal): " . $_SESSION['totalspentthismonth'] . " AED</p>";
                        echo "<p>Remaining Balance: " . ($monthlyBudget - $_SESSION['totalspentthismonth']) . " AED</p>";
                        ?>
                        
                        <h3 class='display4'>Category Breakdown (This Month)</h3>
                        <table class='table'>
                            <tr>
                                <th>Category Name</th>
                                <th>Amount Spent (AED)</th>
                            </tr>
                            <?php
                            $sql = "SELECT categoryName FROM categories";
                            $categories = array();
                            $results = $link->query($sql);
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    $categories[$row['categoryName']] = 0; 
                                }
                            }
                            
                            $sql2 = "SELECT username, cost, date, category FROM expenses";
                            $results2 = $link->query($sql2);
                            $other = 0;
                            
                            if($results2->num_rows > 0){
                                while($row = $results2->fetch_assoc()){
                                    if(date('m') == splitMonth($row['date'])){
                                        if($_SESSION['username'] == $row['username']){
                                            if(in_array($row['category'], $categories)){
                                                $categories[$row['category']] += $row['cost'];
                                            } else {
                                                $other += $row['cost'];
                                            } 
                                        } 
                                    }
                                }
                            }
                            foreach($categories as $category=>$cost){
                                echo "<tr><td>" . $category . "</td><td>" . $cost . "</tr>";
                            }
                            
                            echo "<tr><td> Other </td><td>" . $other . "</td></tr>";
                            
                            
                            ?>
                        </table>


                    </div>
                    <div class='col-lg-6'>
                        <h1 class='display4'>Family Statistics</h1>

                        <?php
                        //displaying family statistics
                        $sql = "SELECT username, budget FROM settings";
                        $results = $link->query($sql);
                        $counter = 0;
                        if($results->num_rows > 0){
                            while($row = $results->fetch_assoc()){   
                                $counter += $row['budget'];
                            }
                        }

                        
                        echo "<p>Total Monthly Budget: " . $counter . "</p>";
                        echo "<p>Total Spent This Month: " . $_SESSION['familyspent'] .  "</p>";
                        echo "<p>Remaining Balance: " . ($counter - $_SESSION['familyspent']) . "</p>";
                        ?>
                        <h3 class='display4'>Category Breakdown (This Month) Family</h3>
                    
                        <table class='table'>
                            <tr>
                                <th>Category Name</th>
                                <th>Amount Spent (AED)</th>
                            </tr>
                        <?php
                        $sql = "SELECT categoryName FROM categories";
                            $categories = array();
                            $results = $link->query($sql);
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    $categories[$row['categoryName']] = 0; 
                                }
                            }
                            
                            $sql2 = "SELECT username, cost, date, category FROM expenses";
                            $results2 = $link->query($sql2);
                            $other = 0;
                            
                            if($results2->num_rows > 0){
                                while($row = $results2->fetch_assoc()){
                                    if(date('m') == splitMonth($row['date'])){
                                        if(!empty(($row['category']))){
                                            if(in_array(($row['category']), $categories)){
                                                $categories[$row['category']] += $row['cost'];
                                            } else {
                                                $other += $row['cost'];
                                            }
                                        } else {
                                            $other += $row['cost'];
                                        }
                                    }
                                }
                            }
                            foreach($categories as $category=>$cost){
                                echo "<tr><td>" . $category . "</td><td>" . $cost . "</tr>";
                            }
                            echo "<tr><td> Other </td><td>" . $other . "</tr>";
                        ?>
                        </table>
                        
                       
                    </div>
                    
                </div>
                <div class='row'>
                    <div class='col-lg-6 mx-auto'>
                        <h2 class='display3'>Category Breakdown Chart (Pers.)</h2>
                        <canvas id='personalcategory'></canvas>
                        <?php
                        $sql = "SELECT categoryName FROM categories";
                        $results = $link->query($sql);
                        $categories = array();
                        if($results->num_rows > 0){
                            while($row = $results->fetch_assoc()){
                                $categories[$row['categoryName']] = 0;
                            }
                        }
                        
                        $sql2 = "SELECT username, cost, date, category FROM expenses";
                        $results2 = $link->query($sql2);
                        if($results2->num_rows > 0){
                            while($row = $results2->fetch_assoc()){
                                if($row['username'] == $_SESSION['username']){
                                    if(date('m') == splitMonth($row['date'])){
                                        if(in_array($row['category'], $categories)){
                                            $categories[$row['category']] += $row['cost'];
                                        } 
                                    } 
                                }
                            }
                        }
                        ?>
                        <script>
                            var categories = <?php echo json_encode($categories); ?>;
                            var categoryNames = [];
                            var categorySpent = [];
                            
                            function chooseColor(max, min){
                                red = Math.random() * (max - min) + min;
                                blue = Math.random() * (max - min) + min;
                                green = Math.random() * (max - min) + min;
                            }
                            for(var i in categories){
                                categoryNames.push(i);
                                categorySpent.push(categories[i]);
                            }
                            var chart2 = document.getElementById('personalcategory');
                            var myChart2 = new Chart(chart2, {
                                type: 'bar',
                                data: {
                                    labels: categoryNames,
                                    datasets: [{
                                        label: false,
                                        data: categorySpent,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(75, 192, 192, 0.2)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            scaleLabel: {
                                                display:true,
                                                labelString:'Amount Spent (AED)',
                                            },
                                        }],
                                        xAxes: [{
                                            scaleLabel: {
                                                display:true,
                                                labelString: 'Category Name',
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });
                        </script>
                        
                    </div>
                    
                    <div class='col-lg-6 mx-auto'>
                        <h2 class='display3'>Category Breakdown Chart (Family)</h2>
                        <canvas id='category'></canvas>
                        <?php
                        $sql = "SELECT categoryName FROM categories";
                        $results = $link->query($sql);
                        $categories = array();
                        if($results->num_rows > 0){
                            while($row = $results->fetch_assoc()){
                                $categories[$row['categoryName']] = 0;
                            }
                        }
                        
                        $sql2 = "SELECT username, cost, date, category FROM expenses";
                        $results2 = $link->query($sql2);
                        if($results2->num_rows > 0){
                            while($row = $results2->fetch_assoc()){
                                if(date('m') == splitMonth($row['date'])){
                                    if(in_array($row['category'], $categories)){
                                        $categories[$row['category']] += $row['cost'];
                                    } 
                                } 
                            }
                        }
                        ?>
                        <script>
                            var categories = <?php echo json_encode($categories); ?>;
                            var categoryNames = [];
                            var categorySpent = [];
                            
                            function chooseColor(max, min){
                                red = Math.random() * (max - min) + min;
                                blue = Math.random() * (max - min) + min;
                                green = Math.random() * (max - min) + min;
                            }
                            for(var i in categories){
                                categoryNames.push(i);
                                categorySpent.push(categories[i]);
                            }
                            var chart2 = document.getElementById('category');
                            var myChart2 = new Chart(chart2, {
                                type: 'bar',
                                data: {
                                    labels: categoryNames,
                                    datasets: [{
                                        label: false,
                                        data: categorySpent,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(75, 192, 192, 0.2)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            scaleLabel: {
                                                display:true,
                                                labelString:'Amount Spent (AED)',
                                            },
                                        }],
                                        xAxes: [{
                                            scaleLabel: {
                                                display:true,
                                                labelString: 'Category Name',
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });
                        </script>
                        
                    </div>
                    
                </div>
                <div class='row'>
                    <div class='col-lg-12 mx-auto'>
                        <h2 class='display3'>Highest Spender This Month</h2>
                        <canvas id="family"></canvas>
                        <?php
                        
                        $sql = "SELECT username FROM login";
                        $results= $link->query($sql);
                        $usernames = array();
                        
                        if($results->num_rows > 0){
                            while($row = $results->fetch_assoc()){
                                $usernames[$row['username']] = 0; 
                            }
                        }
                        $sql2 = "SELECT username, cost, date FROM expenses";
                        $results2 = $link->query($sql2);
                        
                        if($results2->num_rows > 0){
                            while($row = $results2->fetch_assoc()){
                                if(date('m') == splitMonth($row['date'])){
                                    if(in_array($row['username'], $usernames)){
                                        $usernames[$row['username']] += $row['cost'];
                                    }
                                }
                            }
                        }
                        ?>
                        <script>
                            var familyExpenses = <?php echo json_encode($usernames); ?>;
                            var usernames = [];
                            var totalSpent = []
                            for(var i in familyExpenses){
                                usernames.push(i);
                                totalSpent.push(familyExpenses[i]);
                            }
                            var chart = document.getElementById('family');
                            var myChart = new Chart(chart, {
                                type: 'bar',
                                data: {
                                    labels: usernames,
                                    datasets: [{
                                        label: false,
                                        data: totalSpent,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(75, 192, 192, 0.2)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            scaleLabel: {
                                                display:true,
                                                labelString:'Amount Spent (AED)',
                                            },
                                        }],
                                        xAxes: [{
                                            scaleLabel: {
                                                display:true,
                                                labelString: 'User',
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-lg-6'>
                        <h2 class='display2'>Priority Breakdown</h2>
                        <table class='table'>
                            <tr>
                                <th>Priority</th>
                                <th>Total Spent (AED)</th>
                            </tr>
                            <?php
                            $priorities = array('Low' => 0, 'Medium' => 0, 'High' => 0);
                            $sql = "SELECT cost, date, priority FROM expenses";
                            $results = $link->query($sql);
                            
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    if(date('m') == splitMonth($row['date'])){
                                        if(in_array($row['priority'], $priorities)){
                                            $priorities[$row['priority']] += $row['cost'];
                                        }
                                    }
                                }
                            }
                            
                            foreach($priorities as $pri=>$cost){
                                echo "<tr><td>" . $pri . "</td><td>" . $cost . "</tr>";
                            }
                
                            ?>
                        </table>
                    </div>
                    <div class='col-lg-6'>
                        <h2 class='display2'>Priority Breakdown Chart</h2>
                        <canvas id='priority'></canvas>
                        <script>
                            var priorityChart = document.getElementById("priority");
                            var priorities = <?php echo json_encode($priorities); ?>;
                            var priorityNames = [];
                            var priorityCosts = [];
                            
                            for(var i in priorities){
                                priorityNames.push(i);
                                priorityCosts.push(priorities[i]);
                            }
                            console.log(priorities);
                            
                            var priorityChart = new Chart(priorityChart, {
                                type: 'bar',
                                data: {
                                    labels: priorityNames,
                                    datasets: [{
                                        label: false,
                                        data: priorityCosts,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            },
                                            scaleLabel: {
                                                display:true,
                                                labelString:'Amount Spent (AED)',
                                            },
                                        }],
                                        xAxes: [{
                                            scaleLabel: {
                                                display:true,
                                                labelString: 'Priority',
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
                <div class='row'>
                    <div class='col align-self-center'>
                         <h3 class='display4'>Family Budget Breakdown</h3>
                            <table class='table'>
                            <tr>
                                <th>Name</th>
                                <th>Monthly Budget (AED)</th>
                            </tr>
                            <?php
                            
                            $sql = "SELECT username, budget FROM settings";
                            $results = $link->query($sql);
                            
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    echo "<tr><td>" . $row['username'] . "</td><td>" . $row['budget'] . "</td></tr>";
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</div>
</body>
</html>