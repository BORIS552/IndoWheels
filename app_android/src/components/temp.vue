

<!-- Contact details -->
<main class="_main">
      <!-- <Cover :headline="title" :tagline="lang.contactDetails.tagline" /> -->
      <!-- <iframe class="_map" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d117878.27729032867!2d88.37628092818528!3d22.590464387042996!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2902149e9da0b588!2sINDOWHEELS+SALTLAKE!5e0!3m2!1sen!2sin!4v1551207348996" allowfullscreen></iframe> -->
      <div id="map" ref="map" class="_map"></div>
      <div class="_grid">
        <div class="_contact__card _contact__phone">
          <img src="/images/customer-service.svg" alt="" class="_contact__card__icon">
          <div class="_contact__card__text">
            <a href="tel:09830090335">09830090335</a>
          </div>
        </div>
        <div class="_contact__card">
          <img src="/images/gps.svg" alt="" class="_contact__card__icon">
          <div class="_contact__card__text">
            DB-16, 1A Cross Rd, DB Block, Sector 1, Salt Lake City, Kolkata, West Bengal 700064
            <br>
            HCP4+JM Kolkata, West Bengal
          </div>
        </div>
      </div>
      <ContactForm v-show="!isFormSubmitted" :at-submit="onSubmit" />
      <FormConfirmation :headline="lang.common.thankYou" :msg="lang.contact.thanksMsg" icon="/images/high-five.svg" v-show="isFormSubmitted" />
    </main>


    Home.vue Line 47 
    && _lottery.date_formatted === curr_formatted_date