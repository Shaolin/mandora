
<footer class="site-footer">

  <div class="footer-container">

    <!-- Column 1: About / Contact -->
    <div class="footer-col">
      <h3>Mandora Services Ltd</h3>
      <p>Connecting talent with opportunity across the UK.</p>

      <p><strong>Email:</strong> info@mandoraservicesltd.com</p>
      <p><strong>Phone:</strong> +44 123 456 789</p>
      <p><strong>Location:</strong> London, UK</p>
    </div>

    <!-- Column 2: Quick Links -->
    <div class="footer-col">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="<?php echo site_url('/'); ?>">Home</a></li>
       
        <li><a href="#">Partners</a></li>
        <li><a href="#">Career</a></li>
       
      </ul>
    </div>

    <!-- Column 3: Categories -->
    <div class="footer-col">
      <h4>Job Categories</h4>
      <ul>
        <li><a href="<?php echo site_url('/jobs?job_category=healthcare'); ?>">Healthcare</a></li>
        <li><a href="<?php echo site_url('/jobs?job_category=hospitality'); ?>">Hospitality</a></li>
        <li><a href="<?php echo site_url('/jobs?job_category=events'); ?>">Events</a></li>
        <li><a href="<?php echo site_url('/jobs?job_category=cleaning'); ?>">Cleaning</a></li>
      </ul>
    </div>

    <!-- Column 4: Map -->
    <div class="footer-col map">
      <h4>Our Location</h4>

      <!-- <iframe 
  src="https://www.google.com/maps?q=90+Beckhampton+Street,+Swindon,+England,+SN1+2SE&output=embed"
  width="100%" 
  height="200" 
  style="border:0;" 
  allowfullscreen="" 
  loading="lazy">
</iframe> -->
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2480.398156569397!2d-1.7783045235183916!3d51.560934071825564!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4871444bc36872eb%3A0x1c0dc0184fffaa38!2s90%20Beckhampton%20St%2C%20Swindon%20SN1%202LG%2C%20UK!5e0!3m2!1sen!2sng!4v1777179073416!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    </div>

  </div>

  <!-- Bottom Bar -->
  <div class="footer-bottom">
    <p>&copy; <?php echo date('Y'); ?> Mandora Services Ltd. All rights reserved.</p>
  </div>

</footer>

<?php wp_footer(); ?>
<div id="apply-modal" class="apply-modal">
  <div class="apply-modal-content">
    <span class="close-modal">&times;</span>

    <h2>Job Application</h2>

    
    <?php echo do_shortcode('[contact-form-7 id="f0ae16c" title="Application Form"]'); ?>
    

  </div>
</div>

  </div>

</div>
</body>
</html>
