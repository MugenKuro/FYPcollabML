<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        /* Custom CSS for hover animation */
        .custom-button {
            width: 120px; /* Reduced button width */
            height: 120px; /* Reduced button height */
            font-size: 18px; /* Adjusted font size */
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 10px; /* Added margin for spacing */
        }

        .custom-button:hover {
            transform: scale(1.1);
        }

        .buyer-button {
            background-color: #007bff;
            color: #fff;
        }

        .seller-button {
            background-color: #28a745;
            color: #fff;
        }

        .button-container {
            text-align: center;
        }

        .button-box {
            border: 2px solid #ccc;
            border-radius: 15px;
            padding: 20px;
            display: inline-block;
        }

        .question {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        /* Add a custom class for side-by-side buttons */
        .side-by-side {
            display: flex;
            justify-content: center; /* Adjusted to center buttons horizontally */
        }

        /* Add custom styling for the back button */
        .back-button {
            background-color: #dc3545;
            /* Red color */
            color: #fff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
            padding: 10px 20px;
        }

        .back-button:hover {
            background-color: #ff6b75;
            /* Lighter red on hover */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="button-box">
                    <h3 class="question">Are you signing up as an individual seller or representing a company during registration?</h3>
                    <div class="button-container side-by-side">
                        <button class="custom-button buyer-button" onclick="window.location='registerIndSeller.php'">
                            <i class="fas fa-user icon"></i>
                            <span>Individual</span>
                        </button>
                        <button class="custom-button seller-button" onclick="window.location='registerBizSeller.php'">
                            <i class="fas fa-building icon"></i>
                            <span>Company</span>
                        </button>
                    </div>
                    <br>
                    <button class="back-button" onclick="window.location='register.php'">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
