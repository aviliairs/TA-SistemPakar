<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sistem Pakar</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Sistem Pakar Diagnosis Kesehatan Calon Pengantin" />
	<meta name="keywords" content="sistem pakar, kesehatan, calon pengantin, diagnosis" />
	<meta name="author" content="Sistem Pakar" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300' rel='stylesheet' type='text/css'>

	<!-- Animate.css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

	<style>
		/* Custom styles for navigation */
		body {
			font-family: 'Source Sans Pro', sans-serif;
			margin: 0;
			padding: 0;
		}

		#fh5co-wrapper {
			position: relative;
		}

		#fh5co-header {
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(10px);
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			z-index: 1000;
		}

		#fh5co-header-section {
			padding: 25px 0;
		}

		.nav-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		#fh5co-logo a {
			font-size: 28px;
			font-weight: 700;
			color: #2c3e50;
			text-decoration: none;
			letter-spacing: 1px;
		}

		#fh5co-menu-wrap {
			display: flex;
		}

		.sf-menu {
			display: flex;
			list-style: none;
			margin: 0;
			padding: 0;
			gap: 40px;
		}

		.sf-menu li {
			position: relative;
		}

		.sf-menu li a {
			color: #333;
			text-decoration: none;
			font-size: 16px;
			font-weight: 500;
			padding: 15px 0;
			position: relative;
			transition: all 0.3s ease;
			border-bottom: 3px solid transparent;
			cursor: pointer;
		}

		.sf-menu li a:hover {
			color: #b2cff1;
		}

		.sf-menu li.active a,
		.sf-menu li a.active {
			color: #b2cff1;
			border-bottom: 3px solid #b2cff1;
		}

		.fh5co-hero {
			min-height: 100vh;
			position: relative;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.fh5co-overlay {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0, 0, 0, 0.4);
			z-index: 1;
		}

		.fh5co-cover {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-image: url('images/fotoo.jpg');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			overflow: hidden;
			z-index: 0;
		}

		.desc {
			position: relative;
			z-index: 10;
			color: white;
			text-align: center;
			padding: 100px 20px;
		}

		.desc h2 {
			font-size: 4rem;
			font-weight: 300;
			letter-spacing: 4px;
			margin-bottom: 20px;
			text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
		}

		.desc h3 {
			font-size: 1.5rem;
			margin-bottom: 40px;
			opacity: 0.9;
			text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
		}

		.btn-primary {
			background: #7eaadd;
			border: none;
			padding: 15px 40px;
			border-radius: 50px;
			font-size: 16px;
			font-weight: bold;
			text-transform: uppercase;
			letter-spacing: 1px;
			transition: all 0.3s ease;
			text-decoration: none;
			display: inline-block;
			color: white;
		}

		.btn-primary:hover {
			background: #b2cff1;
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(95, 196, 242, 0.4);
			color: white;
		}

		/* Content sections */
		.content-section {
			display: none;
			min-height: 100vh;
			padding: 120px 0 60px;
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
		}

		.content-section.active {
			display: block;
		}

		.content-card {
			background: white;
			padding: 40px;
			border-radius: 20px;
			box-shadow: 0 20px 40px rgba(0,0,0,0.1);
			margin-bottom: 30px;
		}

		.content-card h2 {
			color: #2c3e50;
			margin-bottom: 20px;
			font-size: 2.5rem;
			text-align: center;
		}

		.content-card h3 {
			color: #34495e;
			margin-top: 25px;
			margin-bottom: 15px;
			font-size: 1.5rem;
		}

		.content-card p {
			line-height: 1.8;
			margin-bottom: 15px;
			color: #555;
		}

		.feature-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
			gap: 30px;
			margin-top: 30px;
		}

		.feature-card {
			background: #f8f9fa;
			padding: 30px;
			border-radius: 15px;
			text-align: center;
			transition: transform 0.3s ease;
			border-left: 5px solid #3e6099;
		}

		.feature-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
		}

		.feature-icon {
			font-size: 3rem;
			margin-bottom: 20px;
			color: #7ED321;
		}

		/* Mobile responsive */
		@media (max-width: 768px) {
			.nav-header {
				flex-direction: column;
				gap: 20px;
			}

			.sf-menu {
				gap: 20px;
			}

			.desc h2 {
				font-size: 2.5rem;
			}

			.desc h3 {
				font-size: 1.2rem;
			}
		}

		/* Smooth transitions */
		.content-section {
			opacity: 0;
			transform: translateY(20px);
			transition: all 0.5s ease;
		}

		.content-section.active {
			opacity: 1;
			transform: translateY(0);
		}
	</style>

	</head>
	<body>
		<div id="fh5co-wrapper">
			<div id="fh5co-page">
				<div id="fh5co-header">
					<header id="fh5co-header-section">
						<div class="container">
							<div class="nav-header">
								<h1 id="fh5co-logo"><a href="#" onclick="showSection('home')">Sistem Pakar</a></h1>
								<nav id="fh5co-menu-wrap" role="navigation">
									<ul class="sf-menu" id="fh5co-primary-menu">
										<li class="active">
											<a href="#" onclick="showSection('home')" data-section="home">Home</a>
										</li>
										<li>
											<a href="#" onclick="showSection('tentang-pakar')" data-section="tentang-pakar">Tentang Pakar</a>
										</li>
										<li>
											<a href="#" onclick="showSection('tentang-catin')" data-section="tentang-catin">Kesehatan Catin</a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</header>
				</div>

				<!-- Home Section -->
				<div class="content-section active" id="home">
					<div class="fh5co-hero">
						<div class="fh5co-overlay"></div>
						<div class="fh5co-cover"></div>
						<div class="desc animate-box">
							<h2>Sistem Pakar</h2>
							<h3>Diagnosis Kesehatan Calon Pengantin</h3>
							<span><a class="btn btn-primary" href="login">Diagnosa Sekarang</a></span>
						</div>
					</div>
				</div>

				<!-- Tentang Pakar Section -->
				<div class="content-section" id="tentang-pakar">
					<div class="container">
						<div class="content-card">
							<h2>Tentang Sistem Pakar</h2>
							<p>Sistem pakar adalah sebuah program komputer yang dirancang untuk menirukan kemampuan seorang ahli dalam bidang tertentu. Dalam konteks kesehatan calon pengantin, sistem ini membantu dalam melakukan diagnosis awal kondisi kesehatan yang relevan untuk persiapan pernikahan.</p>

							<h3>Fitur Utama Sistem</h3>
							<div class="feature-grid">
								<div class="feature-card">
									<div class="feature-icon">🔍</div>
									<h4>Diagnosis Berbasis Gejala</h4>
									<p>Sistem menganalisis gejala-gejala yang dialami untuk memberikan diagnosis awal yang akurat</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">💡</div>
									<h4>Rekomendasi Tindakan</h4>
									<p>Memberikan saran tindakan selanjutnya berdasarkan hasil diagnosis yang diperoleh</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">📚</div>
									<h4>Basis Pengetahuan Medis</h4>
									<p>Menggunakan pengetahuan medis yang telah tervalidasi oleh ahli kesehatan profesional</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">👥</div>
									<h4>Interface User-Friendly</h4>
									<p>Antarmuka yang mudah digunakan dan dipahami oleh pengguna awam</p>
								</div>
							</div>

							<h3>Keunggulan Sistem</h3>
							<p>Sistem pakar ini memiliki beberapa keunggulan, antara lain kemampuan untuk memberikan diagnosis yang konsisten, tersedia 24/7, dapat diakses dimana saja, serta membantu deteksi dini masalah kesehatan yang mungkin mempengaruhi kesuburan atau kesehatan reproduksi.</p>

							<h3>Disclaimer</h3>
							<p><strong>Penting:</strong> Hasil diagnosis dari sistem ini bersifat sebagai panduan awal dan tidak menggantikan konsultasi langsung dengan dokter atau tenaga medis profesional. Selalu konsultasikan kondisi kesehatan Anda dengan ahli medis yang kompeten.</p>
						</div>
					</div>
				</div>

				<!-- Tentang Catin Section -->
				<div class="content-section" id="tentang-catin">
					<div class="container">
						<div class="content-card">
							<h2>Tentang Kesehatan Calon Pengantin</h2>
							<p>Kesehatan calon pengantin adalah aspek penting yang perlu diperhatikan sebelum memasuki jenjang pernikahan. Pemeriksaan kesehatan pra-nikah membantu memastikan kedua calon pasangan dalam kondisi sehat dan siap untuk membangun keluarga.</p>

							<h3>Mengapa Pemeriksaan Kesehatan Penting?</h3>
							<div class="feature-grid">
								<div class="feature-card">
									<div class="feature-icon">🏥</div>
									<h4>Deteksi Dini Penyakit</h4>
									<p>Mengidentifikasi penyakit yang mungkin diderita dan belum diketahui sebelumnya</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">🛡️</div>
									<h4>Pencegahan Penularan</h4>
									<p>Mencegah penularan penyakit menular dari satu pasangan ke pasangan lainnya</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">👶</div>
									<h4>Perencanaan Kehamilan</h4>
									<p>Memastikan kondisi kesehatan optimal untuk kehamilan yang sehat</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">🧬</div>
									<h4>Konseling Genetik</h4>
									<p>Memberikan informasi tentang risiko genetik untuk keturunan</p>
								</div>
							</div>

							<h3>Pemeriksaan yang Direkomendasikan</h3>
							<div class="feature-grid">
								<div class="feature-card">
									<div class="feature-icon">🩺</div>
									<h4>Pemeriksaan Fisik Umum</h4>
									<p>Pemeriksaan kondisi fisik secara menyeluruh termasuk vital sign dan sistem organ</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">🧪</div>
									<h4>Tes Laboratorium</h4>
									<p>Pemeriksaan darah, urin, dan tes khusus lainnya sesuai indikasi medis</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">❤️</div>
									<h4>Kesehatan Reproduksi</h4>
									<p>Pemeriksaan sistem reproduksi dan evaluasi tingkat kesuburan</p>
								</div>
								<div class="feature-card">
									<div class="feature-icon">🧠</div>
									<h4>Kesehatan Mental</h4>
									<p>Evaluasi kondisi psikologis dan kesiapan mental untuk berumah tangga</p>
								</div>
							</div>

							<h3>Tips Menjaga Kesehatan Pra-Nikah</h3>
							<p>Untuk menjaga kesehatan optimal sebelum menikah, disarankan untuk menerapkan pola hidup sehat dengan mengonsumsi makanan bergizi seimbang, berolahraga teratur, istirahat yang cukup, menghindari rokok dan alkohol, mengelola stress dengan baik, serta melakukan pemeriksaan kesehatan rutin.</p>

							<p><strong>Ingat:</strong> Investasi terbaik untuk masa depan keluarga adalah kesehatan yang optimal dari kedua calon pasangan.</p>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- Scripts -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

		<script>
			// Navigation functionality
			function showSection(sectionId) {
				// Remove active class from all menu items
				const menuItems = document.querySelectorAll('.sf-menu li');
				menuItems.forEach(item => item.classList.remove('active'));

				// Remove active class from all menu links
				const menuLinks = document.querySelectorAll('.sf-menu a');
				menuLinks.forEach(link => link.classList.remove('active'));

				// Add active class to clicked menu item and link
				const clickedLink = document.querySelector(`[data-section="${sectionId}"]`);
				if (clickedLink) {
					clickedLink.classList.add('active');
					clickedLink.parentElement.classList.add('active');
				}

				// Hide all content sections
				const sections = document.querySelectorAll('.content-section');
				sections.forEach(section => section.classList.remove('active'));

				// Show target section with delay for smooth transition
				setTimeout(() => {
					const targetSection = document.getElementById(sectionId);
					if (targetSection) {
						targetSection.classList.add('active');
					}
				}, 100);
			}



			// Initialize page
			document.addEventListener('DOMContentLoaded', function() {
				// Ensure home section is active by default
				showSection('home');

				// Add smooth scrolling effect
				document.querySelectorAll('a[href^="#"]').forEach(anchor => {
					anchor.addEventListener('click', function (e) {
						e.preventDefault();
					});
				});
			});

			// Handle browser back/forward buttons
			window.addEventListener('popstate', function(e) {
				if (e.state && e.state.section) {
					showSection(e.state.section);
				}
			});

			// Update browser history when section changes
			const originalShowSection = showSection;
			showSection = function(sectionId) {
				originalShowSection(sectionId);
				history.pushState({section: sectionId}, '', `#${sectionId}`);
			};
		</script>
	</body>
</html>
