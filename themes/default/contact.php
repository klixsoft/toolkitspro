<div class="beadcrum textture_background py-4">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <h1>Contact Us</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo get_site_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4 pb-2 contact_form">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <form method="post" class="card p-4 mt-3 card-box contact_form_submit">
                <h5><strong>Leave us message</strong></h5>
                <p class="text-muted">Let us know if you have any question in your mind. we will try our best to help you as much as we can
                    provide to you. Feel free to contact us for any quote.</p>
                <p class="text-muted">OR, You can directly mail us at <a href="mailto:<?php echo get_settings("adminemail"); ?>"><?php echo get_settings("adminemail"); ?></a></p>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-muted">Full Name</label>
                            <input type="text" required disabled name="fullname" class="form-control" placeholder="Full Name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-muted">Email</label>
                            <input type="email" required disabled name="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="text-muted">Subject</label>
                    <input type="text" disabled name="subject" class="form-control" placeholder="Subject">
                </div>

                <div class="form-group mt-3">
                    <label class="text-muted">Message</label>
                    <textarea rows="4" disabled required type="text" name="message" class="form-control" placeholder="Write your Message here *"></textarea>
                </div>

                <?php 
                    /**
                     * RENDER RECAPTCHA CHECKBOX OR INPUT FIELDS
                     */
                    do_action("ast/captcha/render", false);
                ?>
                <input type="text" name="action" class="d-none" value="contact_form">
                <?php
                    echo get_submit_button("Send Message", array(
                        "type" => "submit",
                        "class" => "btn btn-primary btn-block mt-3 py-3 fw-bold"
                    ));
                ?>
            </div>
        </div>
    </div>
</div>