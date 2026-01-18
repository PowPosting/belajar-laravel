<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Web Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <main>
        <div class="login-container" style="background-color: #FFFFFF;">
            <div class="image-illustration">
                <img src="/images/medicine.png" alt="image-illustration" class="img-illustration">
            </div>
            <img src="images/wave.png" alt="wave" class="wave">
            <div class="login-box">
                <img src="images/logo-oryza.png" alt="logo-oryza" class="logo-oryza">
                <h6 class="mt-2">Selamat Datang</h6>
                @if(session('error'))
                    <div class="alert alert-danger mt-2">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="/login" method="post" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <i class="fa-solid fa-user" style="color: #FFD43B;"></i>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                            id="inputUsername" placeholder="username" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <i class="fa-solid fa-lock" style="color: #FFD43B;"></i>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" id="inputPassword" placeholder="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn-login" id="btn-login">Login</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>