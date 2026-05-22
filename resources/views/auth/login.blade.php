<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiBed</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#0057b8,#1976d2);
            overflow:hidden;
        }

        .container{
            width:1000px;
            height:560px;
            background:transparent; 
            border-radius:30px;
            overflow:hidden;
            display:flex;
            box-shadow:0 20px 50px rgba(0,0,0,0.2);
        }

        /* ================= LEFT ================= */

        .left{
            width:55%;
            background:linear-gradient(135deg,#0057b8,#1976d2,#3a8cff);
            position:relative;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            padding:60px;
            overflow:hidden;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }

        /* ================= ANIMASI BERJALAN NAIK TURUN ================= */
        @keyframes walkUpDown {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-35px); /* Naik lebih tinggi agar gerakan berjalan terlihat jelas */
            }
            100% {
                transform: translateY(0px);
            }
        }

        /* bulatan dekorasi */

        .circle1{
            position:absolute;
            width:260px;
            height:260px;
            border-radius:50%;
            background:rgba(255,255,255,0.10);
            bottom:-90px;
            left:-70px;
            animation: walkUpDown 7s ease-in-out infinite;
        }

        .circle2{
            position:absolute;
            width:170px;
            height:170px;
            border-radius:50%;
            background:rgba(255,255,255,0.10);
            bottom:40px;
            left:130px;
            animation: walkUpDown 9s ease-in-out infinite 1s; /* Jeda start 1 detik */
        }

        .circle3{
            position:absolute;
            width:120px;
            height:120px;
            border-radius:50%;
            background:rgba(255,255,255,0.08);
            top:50px;
            right:70px;
            animation: walkUpDown 8s ease-in-out infinite 0.5s;
        }

        .circle4{
            position:absolute;
            width:70px;
            height:70px;
            border-radius:50%;
            background:rgba(255,255,255,0.12);
            top:180px;
            right:160px;
            animation: walkUpDown 6s ease-in-out infinite 1.5s;
        }

        .circle5{
            position:absolute;
            width:40px;
            height:40px;
            border-radius:50%;
            background:rgba(255,255,255,0.15);
            top:120px;
            left:90px;
            animation: walkUpDown 7.5s ease-in-out infinite 2s;
        }

        .top-logo{
            width:170px;
            margin-bottom:35px;
            z-index:2;
        }

        .left h1{
            color:white;
            font-size:60px;
            font-weight:700;
            margin-bottom:20px;
            letter-spacing:2px;
            z-index:2;
        }

        .left p{
            color:white;
            font-size:16px; 
            text-align:center;
            line-height:1.6;
            width:100%; 
            z-index:2;
        }

        /* ================= RIGHT ================= */

        .right{
            width:45%;
            display:flex;
            justify-content:center;
            align-items:center;
            background:white;
            padding:50px;
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        .login-box{
            width:100%;
            max-width:320px;
        }

        .login-box h2{
            font-size:48px;
            margin-bottom:40px;
            color:#222;
            font-weight:600;
            text-align: center; 
        }

        .custom-input-group{
            margin-bottom:25px;
            display:flex;
            flex-direction:column;
        }

        .custom-input-group label{
            margin-bottom:8px;
            color:#555;
            font-size:15px;
            font-weight:500;
            text-align: left; 
        }

        .input-with-icon {
            position: relative;
            width: 100%;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
            transition: 0.3s;
        }

        .custom-input-group input{
            width:100%;
            padding: 15px 15px 15px 45px; 
            border:1px solid #dcdcdc;
            border-radius:12px;
            background:#f5f7fb;
            outline:none;
            font-size:15px;
            transition:0.3s;
        }

        .custom-input-group input:focus{
            border-color:#1976d2;
            background:white;
            box-shadow:0 0 10px rgba(25,118,210,0.2);
        }

        .custom-input-group input:focus + i {
            color: #1976d2;
        }

        .submit-btn{
            width:100%;
            padding:15px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg,#0057b8,#1976d2);
            color:white;
            font-size:17px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            margin-top:10px;
        }

        .submit-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 8px 20px rgba(25,118,210,0.3);
        }

        .alert{
            border-radius:10px;
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width:900px){

            .container{
                flex-direction:column;
                width:95%;
                height:auto;
            }

            .left{
                width:100%;
                padding:50px 25px;
                border-radius: 30px 30px 0 0;
            }

            .right{
                width:100%;
                padding:40px 25px;
                border-radius: 0 0 30px 30px;
            }

            .left h1{
                font-size:42px;
            }

            .left p{
                font-size:15px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="left">

        <div class="circle1"></div>
        <div class="circle2"></div>
        <div class="circle3"></div>
        <div class="circle4"></div>
        <div class="circle5"></div>

        <img src="{{ asset('images/logo2.png') }}" alt="Logo RS" class="top-logo">

        <h1>WELCOME!</h1>

        <p>
            Sistem Manajemen Tempat Tidur Rawat Inap<br>
            Rumah Sakit Akademika Politeknik Negeri Jember
        </p>

    </div>

    <div class="right">

        <div class="login-box">

            <h2>Sign in</h2>

            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">

                @csrf

                <div class="custom-input-group">
                    <label>Username</label>
                    <div class="input-with-icon">
                        <input type="text" name="username" placeholder="Enter username" required>
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>

                <div class="custom-input-group">
                    <label>Password</label>
                    <div class="input-with-icon">
                        <input type="password" name="password" placeholder="Enter password" required>
                        <i class="bi bi-lock-fill"></i>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    Login
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>