<!doctype html>
<html lang="en">

<head>

</head>

<body>
    <div>
        <link href="css/style.css" rel="stylesheet" />
        <div class="register-individual-seller-container">
            <div class="register-individual-seller-container01">
                <div class="register-individual-seller-container02">
                    <span class="register-individual-seller-text">
                        <span>Register</span>
                        <br />
                    </span>
                </div>
                <div class="register-individual-seller-container03"></div>
                <div class="register-individual-seller-container04">
                    <div class="register-individual-seller-container05" onclick="window.location='registerCustomer.php'">
                        <span class="register-individual-seller-text03">
                            Register as Customer
                        </span>
                    </div>
                    <div class="register-individual-seller-container06"></div>
                    <div class="register-individual-seller-container07" onclick="window.location='registerIndSeller.php'">
                        <span class="register-individual-seller-text04">
                            Register as Individual Seller
                        </span>
                    </div>
                    <div class="register-individual-seller-container08"></div>
                    <div class="register-individual-seller-container09" onclick="window.location='registerBizSeller.php'">
                        <span class="register-individual-seller-text05">
                            Register as Business Seller
                        </span>
                    </div>
                </div>
                <div class="register-individual-seller-container10"></div>
                <form class="register-individual-seller-form">
                    <div class="register-individual-seller-container11">
                        <span>Email</span>
                        <input type="text" placeholder="example@example.com"
                            class="register-individual-seller-textinput input" />
                    </div>
                    <div class="register-individual-seller-container12">
                        <span>
                            <span>Username</span>
                            <br />
                        </span>
                        <input type="text" placeholder="example@example.com" enctype="username"
                            class="register-individual-seller-textinput1 input" />
                    </div>
                    <div class="register-individual-seller-container13">
                        <span>Password</span>
                        <input type="text" placeholder="password" class="register-individual-seller-textinput2 input" />
                    </div>
                    <div class="register-individual-seller-container14">
                        <span>Re-type Password</span>
                        <input type="text" placeholder="password" class="register-individual-seller-textinput3 input" />
                    </div>
                    <div class="register-individual-seller-container15">
                        <span>Seller Name</span>
                        <input type="text" placeholder="Seller name"
                            class="register-individual-seller-textinput4 input" />
                    </div>
                    <div class="register-individual-seller-container16">
                        <span>Payment QR code</span>
                        <button type="button" class="register-individual-seller-button button">
                            <span>
                                <span>Upload</span>
                                <br />
                            </span>
                        </button>
                    </div>
                    <div class="register-individual-seller-container17">
                        <span>
                            <span>Description</span>
                            <br />
                        </span>
                        <textarea placeholder="Description of seller"
                            class="register-individual-seller-textarea textarea"></textarea>
                    </div>
                    <div class="register-individual-seller-container18">
                        <span>Full Name</span>
                        <input type="text" placeholder="Full name"
                            class="register-individual-seller-textinput5 input" />
                    </div>
                    <div class="register-individual-seller-container19">
                        <span>date of birth</span>
                        <input type="text" placeholder="dd/mm/yyyy" enctype="business name"
                            class="register-individual-seller-textinput6 input" />
                    </div>
                    <div class="register-individual-seller-container20">
                        <span>Mobile</span>
                        <input type="text" placeholder="98765432" class="register-individual-seller-textinput7 input" />
                    </div>
                    <div class="register-individual-seller-container21">
                        <span>Passport</span>
                        <input type="text" placeholder="passport no."
                            class="register-individual-seller-textinput8 input" />
                    </div>
                    <div class="register-individual-seller-container22">
                        <span>
                            <span>Address</span>
                            <br />
                        </span>
                        <textarea placeholder="Street name, floor-unit, postal code"
                            class="register-individual-seller-textarea1 textarea"></textarea>
                    </div>
                    <div class="register-individual-seller-container23">
                        <span>
                            <span>pick-up address</span>
                            <br />
                        </span>
                        <textarea placeholder="Street name, floor-unit, postal code"
                            class="register-individual-seller-textarea2 textarea"></textarea>
                    </div>
                    <div class="register-individual-seller-container24">
                        <button type="button" class="register-individual-seller-button1 button" onclick="window.location='emailVerify.php'">
                            <span class="register-individual-seller-text30">
                                <span>Submit</span>
                                <br />
                            </span>
                        </button>
                        <button type="button" class="register-individual-seller-button2 button" onclick="window.location='login.php'">
                            <span class="register-individual-seller-text33">
                                <span class="register-individual-seller-text34">Cancel</span>
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