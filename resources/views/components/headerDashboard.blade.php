<header class="dashboard-header">
	<div class="header-left">
		<div class="logo">
			<div class="logoIcon">
				<img class="w-[100px]" src="https://basilstar.com/assets/img/logo/green.png" alt="Basil Star Logo">
			</div>
		</div>
        <div class="header-title">
          <button id="hamburger-menu" class="hamburger-icon">
            <i class="fas fa-bars"></i>
          </button>
          <a href="/liveChart" class="nav-item active home-button">
            <i class="fas fa-home"></i>
          </a>
        </div>
	</div>
	<div class="header-right">
		<nav id="nav-dropdown" class="nav-dropdown">
			<div class="nav-title">Analytics</div>
		
			           <a class="nav-item active" href="/liveChart" class="nav-item active home-button">
                        <i class="fas fa-home"></i> Home
                      </a>
                      
						<a class="nav-item" href="/chatbot">
						<i class="fas fa-search custom-warning"></i> Stock Analyzer
						</a>
						
						<a class="nav-item" href="/TradingDashboard"><i class="fas fa-chart-line custom-info"></i> Daily Analysis</a>
						
						<a class="nav-item" href="/topGainerLosers"><i class="fas fa-chart-line custom-primary"></i>   Market Movers</a>
						
						<a class="nav-item" href="#">
						<i class="fas fa-sliders-h custom-info"></i> Indicators
						</a>
						
						<a class="nav-item" href="#">
						<i class="fas fa-question-circle custom-info"></i> Ask The Analyst
						</a>
						
						<a class="nav-item" href="#">
						<i class="fas fa-wallet custom-success"></i> Free Portfolio Analyze
						</a>
						
						<a class="nav-item" href="#">
						<i class="fas fa-book-reader custom-primary"></i> Learning
						</a>
		</nav>
		<!--<a href="/subscribe" class="subscribe-button">-->
  <!--          <i class="fas fa-bell"></i>-->
  <!--          <span class="subscribe-text">Subscribe</span>-->
  <!--      </a>-->
		<!--<form id="logout-button" class="ht-btn bs-btn logout-form" style="background-color:rgba(255, 0, 0, 0.78); color: white;" action="{{ route('logout') }}" method="POST">-->
		<!--	@csrf-->
		<!--	<button type="submit" class="logout-button">-->
		<!--	<i class="fas fa-sign-out-alt"></i>-->
		<!--	<span class="logout-text">Logout</span>-->
		<!--	</button>-->
		<!--</form>-->
	</div>
</header>
<style>
.logoIcon{
        width: 120px;
}
/* Default: show home, hide hamburger */
.hamburger-icon {
  display: none;
}

.home-button {
  display: inline-flex;
  align-items: center;
}

/* On mobile: show hamburger, hide home */
@media (max-width: 768px) {
     .hamburger-icon {
        display: inline-flex
;
        align-items: center;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        position: absolute;
        z-index: 9999;
        /* width: 150px; */
        /* height: 50px; */
        right: 0;
        top: 0;
        bottom: 0;
    }
        .header-left {
        justify-content: center !important;
        align-items: center;
    }

  .home-button {
    display: none;
  }
}

.subscribe-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
}

/* Adjust icon size if needed */
.subscribe-button i {
    font-size: 18px;
}
#openPopup{
    color: #000;
}
/* Hide text on small screens */
@media (max-width: 768px) {
    .subscribe-text {
        display: none;
    }
    .subscribe-button {
    background-color: transparent;
    color: #007bff;
    padding: 0 10px;
}
.dashboard-header{
    display: block;
}
.nav-dropdown{
    top: 16px;
}
.nav-dropdown.active {
    width: 65%;
    right: 0;
}
}

	#logout-button {
	background-color: rgba(255, 0, 0, 0.78); /* Red background with transparency */
	color: white; 
	padding: 5px 18px; 
	border: none; 
	cursor: pointer; 
	border-radius: 5px; 
	}
	.logout-button {
	display: flex;
	align-items: center;
	gap: 5px;
	background: none;
	border: none;
	color: white;
	font-size: 16px;
	cursor: pointer;
	}
	.logout-button i {
	font-size: 18px;
	}
	/* Hide text on screens smaller than 768px */
	@media (max-width: 768px) {
	.logout-text {
	display: none;
	}
	}
</style>
<script>
	// Logout functionality
	document.getElementById('logout-button').addEventListener('click', async function () {
	  const token = localStorage.getItem('auth_token');
	  if (!token) {
	    alert('No authentication token found.');
	    return;
	  }
	
	  try {
	    const response = await fetch('{{ route('logout') }}', {
	      method: 'POST',
	      headers: {
	        'Content-Type': 'application/json',
	        'Authorization': `Bearer ${token}`,
	        'X-CSRF-TOKEN': '{{ csrf_token() }}'
	      },
	      body: JSON.stringify({})
	    });
	
	    if (response.ok) {
	      localStorage.setItem('logoutAlert', 'true');
	      localStorage.removeItem('auth_token');
	      localStorage.removeItem('user');
	      window.location.href = '/';
	    } else {
	      const data = await response.json();
	      alert(data.message || 'Logout failed.');
	    }
	  } catch (error) {
	    console.error('Error:', error);
	    alert('An error occurred while logging out.');
	  }
	});
</script>