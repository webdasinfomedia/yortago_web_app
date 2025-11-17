<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="footer-widget">
                    <div class="footer-logo-item2">
                        <div class="f-logo">
                            <a href="#"><img src="{{ URL::to($setting['footer_logo']) }}" alt="" width="200" height="60"></a>
                        </div>
                    </div>
                    
                    <ul class="footer-info">
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <span>Address:</span>
                            {{ $setting['address'] }}
                        </li>
                        <li>
                            <i class="fa fa-envelope-o"></i>
                            <span>Email:</span>
                            {{ $setting['email'] }}

                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            <span>Phone:</span>
                            {{ $setting['phone_no'] }}

                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="footer-widget">
                    <h5>Quick Links</h5>
                    <ul class="workout-program">
                        <li><a href="">Home</a></li>
                        <li><a href="{{ route('about.us') }}">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#testimonial">Testimonial</a></li>
                        <li><a href="#newsletter">Newsletter</a></li>
                        <li><a href="{{ route('term.condition') }}">Term and Condition</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footer-logo-item">
                    <div class="social-links">
                        <h6>Follow us</h6>
                        <a href=" {{ $setting['facebook'] }}" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href=" {{ $setting['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href=" {{ $setting['google'] }}" target="_blank"><i class="fab fa-google-plus"></i></a>
                        <a href=" {{ $setting['linkdin'] }}" target="_blank"><i class="fab fa-linkedin"></i></a>
                        <a href=" {{ $setting['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href=" {{ $setting['tiktok'] }}" target="_blank"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="ct-inside">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
