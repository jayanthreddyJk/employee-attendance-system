<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ardhas Time Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        .custom-width{
            max-width: 450px;
        }
    </style>
</head>
<body style="background-color: rgb(11,46,82)">
    <header>
        <nav class="navbar navbar-dark navbar-expand-lg">
            <div class="container">
                <h1><a class="navbar-brand fw-bold fs-4" href="#">Ardhas Time Tracker</a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav fw-bold gap-2 ms-auto">
                        <li class="nav-item"><a class="nav-link  active" href="">Home</a></li>
                        <div class="dropdown nav-item">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Features</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">Self-Service Portal</li>
                                <li class="dropdown-item">Overtime Calculation</li>
                                <li class="dropdown-item">Automated Time Tracking</li>
                                <li class="dropdown-item">Accurate Attendance Reports</li>
                            </ul>
                        </div>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="modal" data-bs-target="#login" href="#" id="login_user">Log In</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('logout.user')}}" id="logout_user" style="display: none;">Log Out</a></li>
                    </ul>
                </div>
            </div>
            <div class="modal fade" id="login" >
                <div class="modal-dialog custom-width">
                    <div class="modal-content px-4">
                        <div class="modal-header">
                            <h3 class="modal-title">Log In</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('login.user') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="email">Email</label>
                                    <input class="form-control" type="email" name="email" id="email" placeholder="Enter Email Address" value={{old('email')}}>
                                    @if($errors->getBag('login')->has('email'))
                                        <div class="text-danger">{{ $errors->getBag('login')->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold"  for="password">Password</label>
                                    <input class="form-control"  type="password" name="password" id="password" placeholder="Enter Password">
                                    @if($errors->getBag('login')->has('password'))
                                        <div class="text-danger">{{ $errors->getBag('login')->first('password') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3 row ps-4">
                                    <div class="form-check col-sm-12 col-md-6">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="checkbox">
                                        <label class="form check-label" for="checkbox">Remember Me</label>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <a href="#">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <strong>ReCaptcha:</strong>
                                    <div style="transform: scale(0.75)">
                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" name="g-recaptcha-response"></div>
                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif
                                    @if($errors->getBag('login')->has('g-recaptcha-response'))
                                    <div class="text-danger">{{ $errors->getBag('login')->first('g-recaptcha-response') }}</div>
                                    @endif
                                </div>
                                @if ($errors->has('loginerror'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('loginerror') }}
                                    </div>
                                @endif
                                <div>
                                    <button class="btn btn-primary px-4 fw-bold" type="submit">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container mt-4 text-align-center">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 mt-5 ">
                    <h1 class="heading text-white fw-bold">Effortless Attendence Management</h1>
                    <h5 class="text-white-50 my-3 pe-3">Streamline your workday with seamless attendance tracking at Ardhas.</h5>
                    <button class="btn btn-primary rounded-pill fw-bold mt-4" data-bs-toggle="modal" data-bs-target="#login">Get Started</button>
                </div>
                <div class="col-12 col-md-6 my-5 align-items-center">
                    <img class="img-fluid rounded-5" src="images\Attendance-Management-System.png" alt="Attendence system image" >
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @if ($errors->hasBag('login') || $errors->has('loginerror'))
    <script>
        $(document).ready(function() {
            $('#login').modal('show');
        });
    </script>
    @endif

    @if (Auth::guard('admin')->check() || Auth::guard('employee')->check())
        <script>
            $(document).ready(function(){
                $('#login_user').hide();
                $('#logout_user').show();
                $('#login').modal('hide');
            });
        </script>
    @endif
</body>
</html>
