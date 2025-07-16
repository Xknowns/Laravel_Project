<?php
require_once 'connection.php';
?> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<title>Login</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
		
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		
		body {
			font-family: 'Inter', sans-serif;
			background: #0a0a0a;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
			overflow: hidden;
		}
		
		body::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: radial-gradient(circle at 20% 80%, #ff00ff 0%, transparent 50%),
						radial-gradient(circle at 80% 20%, #00ffff 0%, transparent 50%),
						radial-gradient(circle at 40% 40%, #ff6b35 0%, transparent 50%);
			animation: morphing 8s ease-in-out infinite;
			filter: blur(100px);
			opacity: 0.3;
		}
		
		@keyframes morphing {
			0%, 100% { transform: scale(1) rotate(0deg); }
			50% { transform: scale(1.1) rotate(180deg); }
		}
		
		.container {
			position: relative;
			z-index: 10;
			max-width: 400px;
			width: 100%;
			padding: 20px;
		}
		
		.login-container {
			background: rgba(20, 20, 20, 0.95);
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 24px;
			padding: 48px 32px;
			box-shadow: 0 32px 64px rgba(0, 0, 0, 0.4);
			position: relative;
			overflow: hidden;
		}
		
		.login-container::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			height: 1px;
			background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
		}
		
		.logo-area {
			text-align: center;
			margin-bottom: 40px;
		}
		
		.logo {
			width: 64px;
			height: 64px;
			background: linear-gradient(135deg, #ff6b35, #f7931e);
			border-radius: 16px;
			margin: 0 auto 16px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 28px;
			font-weight: 700;
			color: white;
			box-shadow: 0 8px 24px rgba(247, 147, 30, 0.3);
		}
		
		.welcome-text {
			color: #ffffff;
			font-size: 24px;
			font-weight: 600;
			margin-bottom: 8px;
		}
		
		.subtitle {
			color: #888;
			font-size: 14px;
		}
		
		.input-group {
			margin-bottom: 24px;
			position: relative;
		}
		
		.input-label {
			display: block;
			color: #ffffff;
			font-size: 14px;
			font-weight: 500;
			margin-bottom: 8px;
		}
		
		.input-field {
			width: 100%;
			padding: 16px;
			background: rgba(255, 255, 255, 0.05);
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 12px;
			color: #ffffff;
			font-size: 16px;
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			outline: none;
		}
		
		.input-field::placeholder {
			color: #666;
		}
		
		.input-field:focus {
			border-color: #ff6b35;
			box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
			background: rgba(255, 255, 255, 0.08);
		}
		
		.login-button {
			width: 100%;
			padding: 16px;
			background: linear-gradient(135deg, #ff6b35, #f7931e);
			border: none;
			border-radius: 12px;
			color: white;
			font-size: 16px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			margin-top: 8px;
			position: relative;
			overflow: hidden;
		}
		
		.login-button::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
			transition: left 0.5s ease;
		}
		
		.login-button:hover {
			transform: translateY(-1px);
			box-shadow: 0 12px 40px rgba(255, 107, 53, 0.4);
		}
		
		.login-button:hover::before {
			left: 100%;
		}
		
		.login-button:active {
			transform: translateY(0);
		}
		
		.divider {
			display: flex;
			align-items: center;
			margin: 32px 0;
			color: #666;
			font-size: 14px;
		}
		
		.divider::before,
		.divider::after {
			content: '';
			flex: 1;
			height: 1px;
			background: rgba(255, 255, 255, 0.1);
		}
		
		.divider span {
			margin: 0 16px;
		}
		
		.register-prompt {
			text-align: center;
			color: #888;
			font-size: 14px;
		}
		
		.register-link {
			color: #ff6b35;
			text-decoration: none;
			font-weight: 500;
			transition: all 0.3s ease;
		}
		
		.register-link:hover {
			color: #f7931e;
			text-decoration: underline;
		}
		
		.floating-shapes {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			pointer-events: none;
			overflow: hidden;
		}
		
		.shape {
			position: absolute;
			background: rgba(255, 255, 255, 0.02);
			border-radius: 50%;
			animation: float-around 20s infinite linear;
		}
		
		.shape:nth-child(1) {
			width: 80px;
			height: 80px;
			top: 10%;
			left: 10%;
			animation-delay: 0s;
		}
		
		.shape:nth-child(2) {
			width: 120px;
			height: 120px;
			top: 60%;
			right: 10%;
			animation-delay: -7s;
		}
		
		.shape:nth-child(3) {
			width: 60px;
			height: 60px;
			bottom: 20%;
			left: 20%;
			animation-delay: -14s;
		}
		
		@keyframes float-around {
			0% { transform: translateY(0px) rotate(0deg); }
			33% { transform: translateY(-20px) rotate(120deg); }
			66% { transform: translateY(20px) rotate(240deg); }
			100% { transform: translateY(0px) rotate(360deg); }
		}
		
		@media (max-width: 768px) {
			.login-container {
				padding: 32px 24px;
			}
			
			.welcome-text {
				font-size: 20px;
			}
		}
	</style>
</head>
<body>
	<div class="floating-shapes">
		<div class="shape"></div>
		<div class="shape"></div>
		<div class="shape"></div>
	</div>
	
	<div class="container">
		<div class="login-container">
			<div class="logo-area">
				<div class="logo">S</div>
				<h1 class="welcome-text">Welcome back</h1>
				<p class="subtitle">Please sign in to your account</p>
			</div>
			
			<form action="index.php" method="post">
				<div class="input-group">
					<label class="input-label">Email address</label>
					<input type="email" name="email" class="input-field" placeholder="jane@doe.com" required>
				</div>
				
				<div class="input-group">
					<label class="input-label">Password</label>
					<input type="password" name="password" class="input-field" placeholder="Enter your password" required>
				</div>
				
				<button type="submit" name="login_btn" class="login-button">Sign in</button>
			</form>
			
			<div class="divider">
				<span>or</span>
			</div>
			
			<div class="register-prompt">
				Don't have an account? <a href="register.php" class="register-link">Sign up</a>
			</div>
		</div>
	</div>
</body>
</html>
