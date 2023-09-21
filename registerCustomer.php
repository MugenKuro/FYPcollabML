<!doctype html>
<html lang="en">

<head>

</head>

<body>
    <div>
        <link href="css/style.css" rel="stylesheet" />
        <div class="register-customer-container">
            <div class="register-customer-container01">
                <div class="register-customer-container02">
                    <span class="register-customer-text">
                        <span>Register</span>
                        <br />
                    </span>
                </div>
                <div class="register-customer-container03"></div>
                <div class="register-customer-container04">
                    <div class="register-customer-container05" onclick="window.location='registerCustomer.php'">
                        <span class="register-customer-text03">Register as Customer</span>
                    </div>
                    <div class="register-customer-container06"></div>
                    <div class="register-customer-container07" onclick="window.location='registerIndSeller.php'">
                        <span class="register-customer-text04">
                            Register as Individual Seller
                        </span>
                    </div>
                    <div class="register-customer-container08"></div>
                    <div class="register-customer-container09" onclick="window.location='registerBizSeller.php'">
                        <span class="register-customer-text05">
                            Register as Business Seller
                        </span>
                    </div>
                </div>
                <div class="register-customer-container10"></div>
                <form class="register-customer-form">
                    <div class="register-customer-container11">
                        <span>Email</span>
                        <input type="text" placeholder="example@example.com"
                            class="register-customer-textinput input" />
                    </div>
                    <div class="register-customer-container12">
                        <span>
                            <span>Username</span>
                            <br />
                        </span>
                        <input type="text" placeholder="example@example.com" enctype="username"
                            class="register-customer-textinput1 input" />
                    </div>
                    <div class="register-customer-container13">
                        <span>Password</span>
                        <input type="text" placeholder="password" class="register-customer-textinput2 input" />
                    </div>
                    <div class="register-customer-container14">
                        <span>Re-type Password</span>
                        <input type="text" placeholder="password" class="register-customer-textinput3 input" />
                    </div>
                    <div class="register-customer-container15">
                        <span>
                            <span>Gender</span>
                            <br />
                        </span>
                        <select class="register-customer-select">
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="register-customer-container16">
                        <span>Date of Birth</span>
                        <input type="text" placeholder="dd/mm/yyyy" class="register-customer-textinput4 input" />
                    </div>
                    <div class="register-customer-container17">
                        <span>First Name</span>
                        <input type="text" placeholder="first name" class="register-customer-textinput5 input" />
                    </div>
                    <div class="register-customer-container18">
                        <span>Last Name</span>
                        <input type="text" placeholder="last name" class="register-customer-textinput6 input" />
                    </div>
                    <div class="register-customer-container19">
                        <span>User Image</span>
                        <button type="button" class="register-customer-button button">
                            <span>
                                <span>Upload</span>
                                <br />
                            </span>
                        </button>
                    </div>
                    <div class="register-customer-container20">
                        <span>Mobile</span>
                        <input type="text" placeholder="98765432" class="register-customer-textinput7 input" />
                    </div>
                    <div class="register-customer-container21">
                        <span>
                            <span>Address</span>
                            <br />
                        </span>
                        <textarea placeholder="Street name, floor-unit, postal code"
                            class="register-customer-textarea textarea"></textarea>
                    </div>
                    <div class="register-customer-container22">
                        <button type="button" class="register-customer-button1 button" onclick="window.location='emailVerify.php'">
                            <span class="register-customer-text26">
                                <span>Submit</span>
                                <br />
                            </span>
                        </button>
                        <button type="button" class="register-customer-button2 button" onclick="window.location='index.php'">
                            <span class="register-customer-text29">
                                <span class="register-customer-text30">Cancel</span>
                                <br />
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</body>

</html>