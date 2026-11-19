
<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- HERO SECTION -->
<section class="hero-section">

    <div class="container">

        <div class="row align-items-center">

            <!-- LEFT CONTENT -->
            <div class="col-lg-6 hero-content">

                <div class="hero-badge">
                    <span class="badge-dot"></span>
                    Your Local Service Marketplace
                </div>

                <h1>
                    Your Everyday Tasks,
                    <span>Handled by Experts.</span>
                </h1>

                <p class="hero-description">
                    From home repairs to everyday essentials, discover
                    trusted local professionals ready to make your life easier.
                </p>

                <!-- SEARCH BOX -->
                <div class="hero-search-box">

                    <div class="search-input-group">
                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="serviceSearch"
                            placeholder="What service are you looking for?"
                        >
                    </div>

                    <div class="search-location-group">
                        <i class="bi bi-geo-alt"></i>

                        <input
                            type="text"
                            id="locationSearch"
                            placeholder="Your city"
                        >
                    </div>

                    <button type="button" id="searchServices">
                        Search
                        <i class="bi bi-arrow-right"></i>
                    </button>

                </div>

                <!-- POPULAR SEARCHES -->
                <div class="popular-searches">

                    <span>Popular:</span>

                    <a href="#services" data-search="Plumbing">Plumbing</a>

                    <a href="#services" data-search="Cleaning">Cleaning</a>

                    <a href="#services" data-search="Electrician">Electrician</a>

                    <a href="#services" data-search="AC Repair">AC Repair</a>

                </div>

                <!-- TRUST INFORMATION -->
                <div class="hero-trust">

                    <div class="trust-item">
                        <i class="bi bi-patch-check-fill"></i>
                        Verified Professionals
                    </div>

                    <div class="trust-item">
                        <i class="bi bi-shield-check"></i>
                        Reliable Services
                    </div>

                </div>

            </div>

            <!-- RIGHT IMAGE -->
            <div class="col-lg-6 hero-image-column">

                <div class="hero-image-wrapper">

                    <img
                        src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=1000&q=85"
                        alt="Professional electrician providing home services"
                        class="hero-main-image"
                    >

                    <div class="hero-floating-card experience-card">

                        <div class="floating-icon">
                            <i class="bi bi-award-fill"></i>
                        </div>

                        <div>
                            <strong>Skilled Experts</strong>
                            <span>Quality you can trust</span>
                        </div>

                    </div>

                    <div class="hero-floating-card service-card">

                        <div class="service-card-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div>
                            <strong>Find Your Expert</strong>
                            <span>Just a few clicks away</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- TRUST STRIP -->
<section class="trust-strip">

    <div class="container">

        <div class="row align-items-center text-center gy-3">

            <div class="col-md-3">
                <div class="trust-strip-item">
                    <i class="bi bi-people-fill"></i>
                    <span>Local Professionals</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="trust-strip-item">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>Secure Bookings</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="trust-strip-item">
                    <i class="bi bi-star-fill"></i>
                    <span>Quality Services</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="trust-strip-item">
                    <i class="bi bi-headset"></i>
                    <span>Customer Support</span>
                </div>
            </div>

        </div>

    </div>

</section>


<!-- =====================================
     POPULAR SERVICE CATEGORIES
====================================== -->



<!-- BROWSE BY CATEGORIES -->
<section class="categories-section" id="services">

    <div class="container">

        <div class="section-heading">
            <div>
                <span class="section-label">EXPLORE SERVORA</span>
                <h2>Browse by <span>Categories</span></h2>
                <p>Find trusted professionals for all your everyday needs.</p>
            </div>
        </div>

        <div class="row g-3">

            <!-- 1. HOME SERVICES -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                        <!-- 1. Home Services -->
                         <img src="/servora/public/assets/images/home-services.jpg"alt="Home Services" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Home Services</h4>
                        <div class="subcategory-list">
                            <a href="#">Electricians</a>
                            <a href="#">Plumbers</a>
                            <a href="#">AC Repair</a>
                            <a href="#">Carpenters</a>
                            <a href="#">Painters</a>
                            <a href="#">Pest Control</a>
                        </div>
                        <a href="/servora/public/index.php?category=home-services" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. PROPERTY -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                        <img src="/servora/public/assets/images/property.jpg"alt="Property Sell and Rent" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Property Sell / Rent</h4>
                        <div class="subcategory-list">
                            <a href="#">House Sale</a>
                            <a href="#">House Rent</a>
                            <a href="#">Flats & Apartments</a>
                            <a href="#">Commercial Spaces</a>
                            <a href="#">Land & Plots</a>
                            <a href="#">Property Agents</a>
                        </div>
                        <a href="/servora/public/index.php?category=property" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. EDUCATION -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                        <img src="/servora/public/assets/images/education.jpg"
     alt="Education and Training" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Education & Training</h4>
                        <div class="subcategory-list">
                            <a href="#">Tuition Teachers</a>
                            <a href="#">Software Training</a>
                            <a href="#">Spoken English</a>
                            <a href="#">Competitive Exams</a>
                            <a href="#">Skill Development</a>
                            <a href="#">Music & Dance</a>
                        </div>
                        <a href="/servora/public/index.php?category=education" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 4. HEALTH -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                        <img src="/servora/public/assets/images/health-wellness.jpg"
     alt="Health and Wellness" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Health & Wellness</h4>
                        <div class="subcategory-list">
                            <a href="#">Doctors</a>
                            <a href="#">Physiotherapists</a>
                            <a href="#">Yoga Trainers</a>
                            <a href="#">Nutritionists</a>
                            <a href="#">Fitness Coaches</a>
                            <a href="#">Home Nursing</a>
                        </div>
                        <a href="/servora/public/index.php?category=health" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 5. EVENTS -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                        <img src="/servora/public/assets/images/events.jpg"
     alt="Events and Celebrations" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Events & Celebrations</h4>
                        <div class="subcategory-list">
                            <a href="#">Wedding Planners</a>
                            <a href="#">Photographers</a>
                            <a href="#">Caterers</a>
                            <a href="#">Decorators</a>
                            <a href="#">DJs & Music</a>
                            <a href="#">Event Venues</a>
                        </div>
                        <a href="/servora/public/index.php?category=events" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 6. AUTOMOBILES -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                       <img src="/servora/public/assets/images/automobiles.jpg"
     alt="Automobiles" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Automobiles</h4>
                        <div class="subcategory-list">
                            <a href="#">Car Repair</a>
                            <a href="#">Bike Repair</a>
                            <a href="#">Car Wash</a>
                            <a href="#">Car Rentals</a>
                            <a href="#">Driving Schools</a>
                            <a href="#">Vehicle Towing</a>
                        </div>
                        <a href="/servora/public/index.php?category=automobiles" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 7. PROFESSIONAL SERVICES -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                        <img src="/servora/public/assets/images/professional-services.jpg"
     alt="Professional Services" loading="lazy" decoding="async">

                    </div>
                    <div class="category-details">
                        <h4>Professional Services</h4>
                        <div class="subcategory-list">
                            <a href="#">Chartered Accountants</a>
                            <a href="#">Lawyers</a>
                            <a href="#">Graphic Designers</a>
                            <a href="#">Web Developers</a>
                            <a href="#">Consultants</a>
                            <a href="#">Digital Marketing</a>
                        </div>
                        <a href="/servora/public/index.php?category=professional" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 8. DAILY HELP -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                       <img src="/servora/public/assets/images/daily-help.jpg"
     alt="Daily Help and Labour" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Daily Help & Labour</h4>
                        <div class="subcategory-list">
                            <a href="#">House Maids</a>
                            <a href="#">Cook Services</a>
                            <a href="#">Babysitters</a>
                            <a href="#">Elderly Care</a>
                            <a href="#">Gardeners</a>
                            <a href="#">General Labour</a>
                        </div>
                        <a href="/servora/public/index.php?category=daily-help" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 9. FOOD -->
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="category-directory-card">
                    <div class="category-image">
                       <img src="/servora/public/assets/images/food-catering.jpg"alt="Food and Catering" loading="lazy" decoding="async">
                    </div>
                    <div class="category-details">
                        <h4>Food & Catering</h4>
                        <div class="subcategory-list">
                            <a href="#">Home Chefs</a>
                            <a href="#">Catering Services</a>
                            <a href="#">Tiffin Services</a>
                            <a href="#">Bakers</a>
                            <a href="#">Party Food</a>
                            <a href="#">Meal Preparation</a>
                        </div>
                        <a href="/servora/public/index.php?category=food" class="category-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>


<!-- HOW SERVORA WORKS -->

<section class="how-it-works-section" id="how-it-works">

    <div class="container">

        <div class="text-center works-heading">
            <span class="section-label">SIMPLE & CONVENIENT</span>

            <h2>Getting help is <span>easy.</span></h2>

            <p>
                Finding the right professional for your needs
                takes just three simple steps.
            </p>
        </div>

        <div class="row g-4">

            <!-- Step 1 -->
            <div class="col-md-4">
                <div class="works-card">

                    <div class="works-icon">
                        <i class="bi bi-search"></i>
                        <span>01</span>
                    </div>

                    <h5>Find a Service</h5>

                    <p>
                        Explore available services and discover
                        professionals in your area.
                    </p>

                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-md-4">
                <div class="works-card">

                    <div class="works-icon">
                        <i class="bi bi-person-check"></i>
                        <span>02</span>
                    </div>

                    <h5>Choose Your Expert</h5>

                    <p>
                        Compare professional profiles and select
                        the right person for your requirements.
                    </p>

                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-md-4">
                <div class="works-card">

                    <div class="works-icon">
                        <i class="bi bi-calendar-check"></i>
                        <span>03</span>
                    </div>

                    <h5>Book Your Service</h5>

                    <p>
                        Send your booking request and get the help
                        you need at your convenience.
                    </p>

                </div>
            </div>

        </div>

    </div>

</section>

<!-- WHY CHOOSE SERVORA -->

<section class="why-servora-section" id="about">

    <div class="container">

        <div class="row align-items-center g-5">

            <!-- LEFT CONTENT -->
            <div class="col-lg-5">

                <span class="section-label">WHY SERVORA?</span>

                <h2 class="why-heading">
                    Making everyday services
                    <span>simple and reliable.</span>
                </h2>

                <p class="why-description">
                    We connect you with skilled local professionals
                    so you can get everyday tasks done with confidence
                    and convenience.
                </p>

                <a href="#" class="btn why-button">
                    Discover Servora
                    <i class="bi bi-arrow-up-right ms-2"></i>
                </a>

            </div>


            <!-- RIGHT FEATURES -->
            <div class="col-lg-7">

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="why-feature-card">
                            <div class="why-feature-icon">
                                <i class="bi bi-patch-check"></i>
                            </div>

                            <h5>Verified Professionals</h5>

                            <p>
                                Find professionals whose profiles
                                are reviewed by our team.
                            </p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="why-feature-card">
                            <div class="why-feature-icon">
                                <i class="bi bi-clock"></i>
                            </div>

                            <h5>Convenient Booking</h5>

                            <p>
                                Discover services and send booking
                                requests with ease.
                            </p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="why-feature-card">
                            <div class="why-feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <h5>Reliable Experience</h5>

                            <p>
                                Access clear professional profiles
                                and service information.
                            </p>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="why-feature-card">
                            <div class="why-feature-icon">
                                <i class="bi bi-headset"></i>
                            </div>

                            <h5>Customer Support</h5>

                            <p>
                                Get assistance when you need help
                                with your service experience.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- JOIN SERVORA CTA SECTION -->

<section class="join-servora-section">

    <div class="container">

        <div class="join-servora-content">

            <span class="join-badge">
                YOUR NEXT STEP STARTS HERE
            </span>

            <h2>
                Great service is just
                <span>around the corner.</span>
            </h2>

            <p>
                Whether you need a helping hand or want to grow
                your service business, Servora brings opportunities
                closer to you.
            </p>

            <div class="join-buttons">

                <a href="index.php?view=register" class="join-primary-btn">
                    Find a Professional
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="index.php?view=provider-register" class="join-secondary-btn">
                    Become a Service Provider
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>

        </div>

    </div>

</section>

<!-- CONTACT SECTION -->

<section class="contact-section" id="contact">

    <div class="container">

        <div class="row g-5 align-items-center">

            <!-- Contact Information -->
            <div class="col-lg-5">

                <span class="section-label">GET IN TOUCH</span>

                <h2 class="contact-heading">
                    We're here to
                    <span>help you.</span>
                </h2>

                <p class="contact-description">
                    Have a question about Servora? Need assistance?
                    Send us a message and our team will get back to you.
                </p>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <div>
                        <h6>Email Us</h6>
                        <p>support@servora.in</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon">
                        <i class="bi bi-headset"></i>
                    </div>

                    <div>
                        <h6>Customer Support</h6>
                        <p>We're here to assist you.</p>
                    </div>
                </div>

            </div>


            <!-- Contact Form -->
            <div class="col-lg-7">

                <div class="contact-form-card">

                    <h4>Send us a message</h4>

                    <p>Fill in the details below and we'll be in touch.</p>

                    <form id="contactForm">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="contactName">Your Name</label>

                                <input
                                    type="text"
                                    id="contactName"
                                    name="name"
                                    class="form-control"
                                    placeholder="Enter your name"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="contactEmail">Email Address</label>

                                <input
                                    type="email"
                                    id="contactEmail"
                                    name="email"
                                    class="form-control"
                                    placeholder="Enter your email"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label for="contactSubject">Subject</label>

                                <input
                                    type="text"
                                    id="contactSubject"
                                    name="subject"
                                    class="form-control"
                                    placeholder="How can we help?"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label for="contactMessage">Your Message</label>

                                <textarea
                                    id="contactMessage"
                                    name="message"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Write your message..."
                                    required
                                ></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="contact-submit-btn">
                                    Send Message
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<?php include APP_ROOT . '/app/views/layouts/footer.php'; ?>