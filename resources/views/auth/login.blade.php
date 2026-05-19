<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiBed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #741a75, #f4c0ef);
    }

    .container {
        width: 90%;
        max-width: 1100px;
        height: 600px;
        display: flex;
        background: linear-gradient(135deg, #ffcce5, #e054d9);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .top-logo {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 320px;
    }

    .left {
        flex: 1;
        padding: 60px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding-bottom: 80px;
    }

    .left h1 {
        font-size: 60px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #790d59;
    }

    .left p {
        font-size: 14px;
        width: 80%;
        margin-bottom: 30px;
        color: #7d1863;
    }

    .right {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px; /* ← penting */
    }

    .login-box {
        width: 100%;
        max-width: 360px;
        padding: 40px 35px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        color: white;
        box-sizing: border-box;
    }

    .login-box h2 {
        text-align: center;
        margin-bottom: 30px;
        color: rgb(92, 12, 82);
    }

    .input-group {
        margin-bottom: 20px;
        width: 100%;
    }

    .input-group label {
        font-size: 14px;
        color: #7d1863;
        display: block;
        margin-bottom: 5px;
    }

    .input-group input {
    width: 100% !important;
    padding: 12px 20px !important;
    border: none !important;
    border-radius: 25px !important;
    outline: none !important;
    background: white !important;
    font-size: 14px !important;
    box-sizing: border-box !important;
    display: block !important;
    margin: 0 !important;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 25px;
        background: linear-gradient(to right, #741a75, #cf02bb);
        color: white;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
        font-size: 15px;
        box-sizing: border-box;
    }
</style>
</head>
<body>
<div class="container">
    <img src="{{ asset('images/logo.png') }}" alt="Logo RS" class="top-logo">

    <div class="left">
        <h1>Welcome!</h1>
        <p>Sistem Manajemen Tempat Tidur Rawat Inap Rumah Sakit Akademika Politeknik Negeri Jember.</p>
    </div>

    <div class="right">
        <div class="login-box">
            <h2>Sign in</h2>

            {{-- Tampilkan error --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- ↓ Ganti route ke login.post --}}
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="********" required>
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>

        </div>
    </div>
</div>
</body>
</html>