<nav class="navbar navbar-expand-lg navbar-light bg-transparent px-5 mx-5">
    <a class="navbar-brand" href="{{url('')}}">
        <img class="sites-logo box-shadow-container rounded-circle" src="/img/logo.png" alt="Workshop Logo"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fa fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item active">
                <a class="nav-link" href="{{url('')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('posts')}}">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('users')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('contact')}}">Contact Us</a>
            </li>
            @if (Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="{{url('profile')}}">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{url('login')}}">Login</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{url('register')}}">Create Account</a>
            </li>
            @endif
        </ul>
    </div>
</nav>
