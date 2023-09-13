<?php
    require 'indexheader.php';
    require 'includes/dbh.inc.php';
?>

    <main>
        <div>
            <section class="home" id="home">
                <div class="container">
                    <div class="text-center" >
                    </div>
                <h3 class="text-center" data-aos="fade-down">WELCOME TO THE</h3>
                <h2 class="text-center" data-aos="fade-left" style="font-weight: bold;">
                    MUNICIPALITY OF <span class="text-warning">BINALBAGAN</span>
                </h2>
                </div>
            </section>

    <section class="about bg-info" id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="img/mayor.jpg" alt="Image description" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="text-uppercase font-weight-bold" style="color: #074160; font-size: 44px; font-weight: 800; line-height: 50px;">Mayor's Welcome</h2>
                    <div class="text-section">
                        <p class="text-white">Welcome to the official website of the Municipality of Binalbagan!</p>
                        <p class="text-white">If you're looking to rent a stall or inquire about available stalls in our town, we extend our warmest welcome to you. Our community is known for its exceptional hospitality, and we eagerly anticipate the opportunity to assist you in finding the perfect stall for your business or exploring the range of stalls available to suit your needs.</p>
                    </div>
                    <div class="d-flex flex-row">
                        <a href="index.php#aboutbplo" class="btn btn-primary mr-2 custom-button">About BPLO</a>
                        <a href="index.php#inquire" class="btn btn-secondary custom-button">Inquire Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

            <section class="about bg-custom" id="aboutbplo">
                <div class="row justify-content-center" data-aos="fade-down">
                    <h1 class="text-white">About BPLO</h1>
                </div>
                <hr>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6" data-aos="fade-right">
                            <p class="text-white">The Business Permits and Licensing Office (BPLO) is a dedicated government agency responsible for streamlining the process of obtaining permits and licenses for businesses. Our team of highly skilled and experienced professionals work diligently to ensure a smooth and efficient experience for business owners looking to establish or expand their operations.</p>
                        </div>
                        <div class="col-md-4" data-aos="fade-left">
                            <img src="img/bplo.jpg" alt="BPLO Office" class="img-fluid medium-image">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12" data-aos="fade-up">
                            <p class="text-white">BPLO offers a variety of services to assist entrepreneurs and business owners in securing the necessary permits and licenses for their establishments. One of our key services includes providing assistance in finding suitable stalls for rent. We maintain an up-to-date database of available commercial spaces and work closely with property owners to ensure a hassle-free rental process.</p>
                            <p class="text-white">Our office is committed to promoting economic growth by fostering a business-friendly environment. We continuously work towards improving our services to accommodate the needs of business owners and reduce the time and effort required to obtain permits and licenses. With our streamlined processes and dedicated support, you can confidently focus on the success of your business.</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4" data-aos="fade-up">
                            <div class="icon-box">
                                <i class="fas fa-users" style="color: #007bff;"></i>
                                <h4 class="title">Tenants</h4>
                                <p class="text-white">We provide support to both new and existing tenants to ensure a smooth business operation.</p>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up">
                            <div class="icon-box">
                                <i class="fas fa-question" style="color: #007bff;"></i>
                                <h4 class="title">Inquiry</h4>
                                <p class="text-white">Our team is ready to assist those who inquire about starting a business, guiding them through the process, and informing them about the submission of necessary documents for permits and licenses.</p>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up">
                            <div class="icon-box">
                                <i class="fas fa-store-alt" style="color: #007bff;"></i>
                                <h4 class="title">Stalls</h4>
                                <p class="text-white">We assist entrepreneurs in finding suitable stalls for rent and maintain an up-to-date database of available commercial spaces.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <p class="text-white">For more information about our services or to inquire about available stalls for rent, please do not hesitate to contact us. Our team is always ready to help and provide guidance throughout the process. Together, we can build a thriving business community that to the overall economic growth of our region </p>
                        </div>
                    </div>
                </div>
            </section>

        <section class="stalls stalls-section" id="stalls">
            <?php include('stallsection.php'); ?>   
        </section>

        <section class="bg-primary" id="inquire">
            <?php include('inquiry.php'); ?>   
        </section>
    </div>
</main>
<?php
    require 'indexfooter.php';
?>