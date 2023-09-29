<!doctype html>
<html lang="en">

<head>

</head>

<body>
    <div>
        <link href="css/style.css" rel="stylesheet" />
        <div class="register-business-seller-container">
            <div class="register-business-seller-container01">
                <div class="register-business-seller-container02">
                    <span class="register-business-seller-text">
                        <span>Register</span>
                        <br />
                    </span>
                </div>
                <div class="register-business-seller-container03"></div>
                <div class="register-business-seller-container04">
                    <div class="register-business-seller-container05" onclick="window.location='registerCustomer.php'">
                        <span class="register-business-seller-text03">
                            Register as Customer
                        </span>
                    </div>
                    <div class="register-business-seller-container06"></div>
                    <div class="register-business-seller-container07" onclick="window.location='registerIndSeller.php'">
                        <span class="register-business-seller-text04">
                            Register as Individual Seller
                        </span>
                    </div>
                    <div class="register-business-seller-container08"></div>
                    <div class="register-business-seller-container09" onclick="window.location='registerBizSeller.php'">
                        <span class="register-business-seller-text05">
                            Register as Business Seller
                        </span>
                    </div>
                </div>
                <div class="register-business-seller-container10"></div>
                <form class="register-business-seller-form">
                    <div class="register-business-seller-container11">
                        <span>Email</span>
                        <input type="text" placeholder="example@example.com"
                            class="register-business-seller-textinput input" />
                    </div>
                    <div class="register-business-seller-container12">
                        <span>
                            <span>Username</span>
                            <br />
                        </span>
                        <input type="text" placeholder="example@example.com" enctype="username"
                            class="register-business-seller-textinput1 input" />
                    </div>
                    <div class="register-business-seller-container13">
                        <span>Password</span>
                        <input type="text" placeholder="password" class="register-business-seller-textinput2 input" />
                    </div>
                    <div class="register-business-seller-container14">
                        <span>Re-type Password</span>
                        <input type="text" placeholder="password" class="register-business-seller-textinput3 input" />
                    </div>
                    <div class="register-business-seller-container15">
                        <span>Seller Name</span>
                        <input type="text" placeholder="Seller name"
                            class="register-business-seller-textinput4 input" />
                    </div>
                    <div class="register-business-seller-container16">
                        <span>Payment QR code</span>
                        <button type="button" class="register-business-seller-button button">
                            <span>
                                <span>Upload</span>
                                <br />
                            </span>
                        </button>
                    </div>
                    <div class="register-business-seller-container17">
                        <span>
                            <span>Description</span>
                            <br />
                        </span>
                        <textarea placeholder="Description of seller"
                            class="register-business-seller-textarea textarea"></textarea>
                    </div>
                    <div class="register-business-seller-container18">
                        <span>Business name</span>
                        <input type="text" placeholder="full name" enctype="business name"
                            class="register-business-seller-textinput5 input" />
                    </div>
                    <div class="register-business-seller-container19">
                        <span>UEN</span>
                        <input type="text" placeholder="UEN" enctype="business name"
                            class="register-business-seller-textinput6 input" />
                    </div>
                    <div class="register-business-seller-container20">
                        <span>
                            <span>Address</span>
                            <br />
                        </span>
                        <textarea placeholder="Street name, floor-unit, postal code"
                            class="register-business-seller-textarea1 textarea"></textarea>
                    </div>
                    <div class="register-business-seller-container21">
                        <span>
                            <span>pick-up address</span>
                            <br />
                        </span>
                        <textarea placeholder="Street name, floor-unit, postal code"
                            class="register-business-seller-textarea2 textarea"></textarea>
                    </div>
                    <div class="register-business-seller-container22">
                        <button type="button" class="register-business-seller-button1 button" onclick="window.location='emailVerify.php'">
                            <span class="register-business-seller-text28">
                                <span>Submit</span>
                                <br />
                            </span>
                        </button>
                        <button type="button" class="register-business-seller-button2 button" onclick="window.location='login.php'">
                            <span class="register-business-seller-text31">
                                <span class="register-business-seller-text32">Cancel</span>
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