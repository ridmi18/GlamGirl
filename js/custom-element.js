class FooterSection extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });

    }

    connectedCallback() {
        const style = document.createElement('style');
        style.textContent = `
        @import url('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
        @import url('../css/style.css');
        @import url('../css/responsive.css');
        `;
        this.shadowRoot.appendChild(style);


        this.shadowRoot.innerHTML += `

        <style>

        .info_section {
            background-color: #160e0b;
            color: #ffffff;
          }
          
          .info_section .info_form_social_row {
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            margin-bottom: 45px;
          }
          
          .info_section .info_form {
            width: 80%;
          }
          
          .info_section .info_form form {
            display: -webkit-box;
            display: -ms-flexbox;
            display: block;
            -webkit-box-align: end;
                -ms-flex-align: end;
                    align-items: flex-end;
          }
          
          
          
          
          .info_section .info_form form input::placeholder {
            color: #9c9c9c;
          }
          
          .info_section .info_form form button {
            background-color: transparent;
            color: #ed247c;
            text-transform: uppercase;
            font-size: 12px;
            outline: none;
            border: none;
            display: inline-block;
            padding: 15.5px 25px;
            background-color: #ed247c;
            color: #ffffff;
            border-radius: 0;
            border: 1px solid #ed247c;
            -webkit-transition: all .2s;
            transition: all .2s;
          }
          
          .info_section .info_form form button:hover {
            background-color: transparent;
            color: #ed247c;
          }
          
          .info_section .social_box {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
          }
          
          .info_section .social_box a {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            width: 50px;
            height: 50px;
            border: 1px solid #ffffff;
            color: #ffffff;
            margin-right: 10px;
          }
          
          .info_section .social_box a:hover {
            color: #ed247c;
            border-color: #ed247c;
          }
          
          .info_section h4 {
            margin-bottom: 15px;
          }
          
          .info_section .info_links .info_links_menu {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
                -ms-flex-direction: column;
                    flex-direction: column;
          }
          
          .info_section .info_links .info_links_menu a {
            color: #ffffff;
          }
          
          .info_section .info_links .info_links_menu a:not(:nth-last-child(1)) {
            margin-bottom: 10px;
          }
          
          .info_section .info_links .info_links_menu a:hover {
            color: #ed247c;
          }
          
          .info_section .info_insta .insta_box {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
          }
          
          .info_section .info_insta .insta_box .img-box {
            width: 65px;
            min-width: 65px;
            height: 65px;
            padding: 10px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            margin-right: 10px;
            background-color: #ffffff;
          }
          
          .info_section .info_insta .insta_box .img-box img {
            max-width: 100%;
            max-height: 100%;
          }
          
          .info_section .info_insta .insta_box p {
            margin: 0;
          }
          
          .info_section .info_insta .insta_box:not(:nth-last-child(1)) {
            margin-bottom: 15px;
          }
          
          .info_section .info_contact a {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            color: #ffffff;
            margin-bottom: 10px;
          }
          
          .info_contact{
            margin-left: 30%;
          }
          .info_section .info_contact a i {
            margin-right: 5px;
            width: 25px;
          }
          
          .info_section .info_contact a:hover:hover {
            color: #ed247c;
          }
          
          /* footer section*/
          .footer_section {
            position: relative;
            text-align: center;
          }
          
          .footer_section p {
            color: #000000;
            padding: 25px 0;
            margin: 0;
          }
          
          .footer_section p a {
            color: inherit;
          }
            .form-control{
                background-color: #000000 !important;
                color: #ffffff !important;
                border: 1px solid #ed247c !important;
            }
            .btn-primary {
                color:rgb(0, 0, 0) !important;
                background-color: #ed247c !important;
                border-color: #ed247c !important;
            }
            .social_box a {
                border: 1px solid #ed247c !important;
                color: #ed247c !important;
            }
            .social_box a:hover {
                border: 1px solidrgb(255, 255, 255) !important;
                color:rgb(254, 254, 254) !important;
                background-color: #ed247c !important;
            }

        </style>

        <section class="info_section layout_padding2 mt-5">
            <div class="container text-center py-5">

                <div class="row info_form_social_row">

                    <div class="col-md-12 col-lg-12">
                        <h2 class="text-center mb-5">Contact Us</h2>
                        <div class="info_orm">
                            <form action="">
                                <input type="text" name="email" class="form-control mb-3" placeholder="Enter your Email">
                                <input type="text" name="message" class="form-control mb-3" placeholder="Enter your message">
                                <button class="btn btn-primary">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row info_main_row">
                    <div class="col-md-6 col-lg-4">
                        <div class="info_links">
                            <h4>Menu</h4>
                            <div class="info_links_menu">
                                <a href="index.php">Home</a>
                                <a href="products.php">Products</a>
                                <a href="cart.php">My Cart</a>
                                <a href="signup.php">Signup</a>
                                <a href="login.php">Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="info_insta">
                            <h4>Follow Us</h4>
                            <div class="social_box justify-content-center">
                                <a href="" class="btn btn-outline-light"><i class="fa fa-facebook"></i></a>
                                <a href="" class="btn btn-outline-light"><i class="fa fa-twitter"></i></a>
                                <a href="" class="btn btn-outline-light"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <h4>Contact Us</h4>
                        <div class="info_contact">
                            <a href=""><i class="fa fa-map-marker" aria-hidden="true"></i><span>Maharagama</span></a>
                            <a href=""><i class="fa fa-phone" aria-hidden="true"></i><span>Call 0112-123-123</span></a>
                            <a href=""><i class="fa fa-envelope"></i><span>glamgirl@gmail.com</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer_section">
                <div class="container">
                    <p class="text-light">&copy; <span id="displayYear"></span> All Rights Reserved By Glamgirl</p>
                </div>
            </footer>
        </section>
        `;
    }
}

// Define the custom element
customElements.define('footer-section', FooterSection);
