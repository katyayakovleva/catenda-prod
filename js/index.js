//accordions
const accordions = document.querySelectorAll(
  ".accordion, .burger__menu > div > ul > li"
);

const divAccordions = [];
const liAccordions = [];

accordions.forEach((accordion) => {
  if (accordion.tagName.toLowerCase() === "div") {
    divAccordions.push(accordion);
  } else if (accordion.tagName.toLowerCase() === "li") {
    liAccordions.push(accordion);
  }
});

const accordionAcions = (accordion, index, allAccordions) => {
  const header = accordion.querySelector(
    ".accordion__header, .burger__menu > div > ul > li > a"
  );
  const content = accordion.querySelector(
    ".accordion__content, .burger__menu > div > ul > li > div"
  );

  if (index === 0) {
    accordion.classList.add("open");
    content.style.maxHeight = content.scrollHeight + 200 + "px";
  }

  header.addEventListener("click", () => {
    if (!accordion.classList.contains("open")) {
      allAccordions.forEach((otherAccordion) => {
        if (otherAccordion !== accordion) {
          otherAccordion.classList.remove("open");
          const otherContent = otherAccordion.querySelector(
            ".accordion__content, .burger__menu > div > ul > li > div"
          );
          if (otherContent) {
            otherContent.style.maxHeight = null;
          }
        }
      });
    }

    accordion.classList.toggle("open");
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + 24 + "px";
    }
  });
};

divAccordions.forEach((accordion, index) => {
  accordionAcions(accordion, index, divAccordions);
});

liAccordions.forEach((accordion, index) => {
  accordionAcions(accordion, index, liAccordions);
});

const firstAccordionContent = document.querySelector(".accordion__content");
if (firstAccordionContent) {
  const firstLink = firstAccordionContent.querySelector("a");
  if (firstLink) {
    firstLink.classList.add("active");
  }
}

document.querySelectorAll(".accordion__content a").forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    document.querySelectorAll(".accordion__content a").forEach((link) => {
      link.classList.remove("active");
    });
    this.classList.add("active");
  });
});

//main page image change
const mainImage = document.getElementById("main-dashboard-image");
const mobileImages = document.querySelectorAll(".benefits__graph_mobile img");

const accordionLinks = document.querySelectorAll(".accordion__content a");

accordionLinks.forEach((link) => {
  link.addEventListener("click", (event) => {
    event.preventDefault();

    const newSrc = link.dataset.img;

    if (newSrc) {
      mainImage.src = newSrc;
      mobileImages.forEach((el) => {
        el.src = newSrc;
      });
    }
  });
});

//counters
const counters = document.querySelectorAll(".counter");

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("in-view");
        observer.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.2 }
);

counters.forEach((counter) => observer.observe(counter));

//fade animations
const fadeContainers = document.querySelectorAll(".fade-container");
const fadeElements = document.querySelectorAll(".fade");

fadeContainers.forEach((container) => {
  const fadeElements = container.querySelectorAll(".fade");

  fadeElements.forEach((el, index) => {
    el.style.transitionDelay = `${0.1 * index}s`;

    observer.observe(el);
  });
});

const observerOptions = {
  threshold: 0.1,
  /* 0.1 means the callback triggers when 
         at least 10% of element is in viewport */
};

const observer2 = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      // Add .show to trigger fade-in
      entry.target.classList.add("show");
      // Optional: Stop observing once shown
      observer2.unobserve(entry.target);
    }
  });
}, observerOptions);

fadeElements.forEach((el) => {
  observer2.observe(el);
});

//parallax
const parallaxElements = document.querySelectorAll(".parallax");

window.addEventListener("scroll", () => {
  const scrollY = window.scrollY; // how far user has scrolled

  parallaxElements.forEach((elem) => {
    // Grab direction ('left' or 'right') and speed from data attributes
    const direction = elem.dataset.direction || "left";
    const speed = parseFloat(elem.dataset.speed) || 0.2;

    // Amount to move based on scroll
    // E.g. if scrollY = 200, speed=0.2 => offset = 200 * 0.2 = 40px
    const offset = scrollY * speed;

    // Combine direction + offset into a transform
    // We'll keep the fade's translateY(0) from the .show class,
    // but we add an additional X translation for the parallax

    if (direction === "left") {
      elem.style.transform = `translateX(-${offset}px)`;
    } else if (direction === "right") {
      elem.style.transform = `translateX(${offset}px)`;
    } else if (direction === "up") {
      elem.style.transform = `translateY(-${offset}px)`;
    } else if (direction === "down") {
      elem.style.transform = `translateY(${offset}px)`;
    }
  });
});

// drawer
const burgerIcon = document.querySelector(".burger__icon");
const burgerMenu = document.querySelector(".burger__menu");

if (burgerIcon && burgerMenu) {
  burgerIcon.addEventListener("click", () => {
    burgerIcon.classList.toggle("active");
    burgerMenu.classList.toggle("active");
    document.body.style.overflow = burgerMenu.classList.contains("active")
      ? "hidden"
      : "";
  });

  document.addEventListener("click", (event) => {
    if (
      !burgerMenu.contains(event.target) &&
      !burgerIcon.contains(event.target)
    ) {
      burgerIcon.classList.remove("active");
      burgerMenu.classList.remove("active");
      document.body.style.overflow = "";
    }
  });
}

//swiper
if (typeof Swiper !== "undefined") {
  const swiper = new Swiper(".mySwiper", {
    slidesPerView: 2,
    spaceBetween: 16,
    grabCursor: true,

    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints: {
      600: { slidesPerView: 3, spaceBetween: 24 },
      1024: { slidesPerView: 4 },
    },
  });

    const slides = document.querySelectorAll(".swiper-slide");
    const caseSlides = document.querySelectorAll(".case-swiper .swiper-slide");

  if (slides.length < 5 && window.matchMedia("(min-width: 1024px)").matches) {
    const swiperElement = document.querySelector('.swiper');
	  
    if (swiperElement) {
      swiperElement.style.setProperty('padding-bottom', '0', 'important');
    }
	 
  }
	else {
		const caseSwiperElement = document.querySelector(".case-swiper");
		const integrationsElement = document.querySelector(".integrations");
		const ctaElement = document.querySelector(".cta");

if (caseSwiperElement && integrationsElement && ctaElement) {
	      ctaElement.style.setProperty('margin-top', '120px');
}
	}
	
	  if (slides.length < 4 && window.matchMedia("(min-width: 768px)").matches) {
	const wrapperElement = document.querySelector(".swiper-wrapper");
	  
	 if (wrapperElement) {		 
	  wrapperElement.style.setProperty('justify-content', 'center', 'important');
	 }
  }

  if (slides.length > 2) {
    const partnerSwiper = new Swiper(".case-swiper", {
      slidesPerView: 1,
      spaceBetween: 16,
      grabCursor: true,
      grid: {
        rows: 1,
        fill: "row",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
		
				    breakpoints: {
      768: {  grid: {
        rows: 3,
        fill: "column",
      }},
    },
    });


    caseSlides.forEach(slide => {
      slide.style.display = "flex";
      slide.style.gap = "24px";
    });
  } else {
    const wrapper = document.querySelector(".case-swiper .swiper-wrapper");

    slides.forEach(slide => {
      slide.style.display = "flex";
      slide.style.gap = "24px";
    });

    const partnerSwiper = new Swiper(".case-swiper", {
      slidesPerView: 1,
      spaceBetween: 16,
      grabCursor: true,
      grid: {
        rows: 2,
        fill: "column",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
	  
	    partnerSwiper.on("slideChange", function () {
    window.scrollTo({ top: 350, behavior: "smooth" });
  });
  }


} else {
  console.warn("Swiper not defined");
}

//popups
const learnMoreButtons = document.querySelectorAll(".learn-more-btn");

learnMoreButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    const popupId = btn.getAttribute("data-popup-id");
    const popup = document.getElementById(popupId);
    if (popup) {
      popup.classList.add("show");

      const closeBtn = popup.querySelector(".popup__close");
      const overlay = popup.querySelector(".popup__overlay");

      // Додаємо прослуховувач подій для закриття popup
      closeBtn.addEventListener("click", () => {
        popup.classList.remove("show");
      });

      overlay.addEventListener("click", () => {
        popup.classList.remove("show");
      });
    }
  });
});

//terms checkbox
const termsCheckbox = document.getElementById("terms");
const submitButton = document.querySelector(".main-button_submit");

if (termsCheckbox) {
  termsCheckbox.addEventListener("change", () => {
    if (termsCheckbox.checked) {
      submitButton.disabled = false;
    } else {
      submitButton.disabled = true;
    }
  });
}


		const storiesElement = document.querySelector(".stories");
		const integrationsElement = document.querySelector(".integrations");

if (storiesElement && integrationsElement) {
	      storiesElement.style.setProperty('padding-top', '240px');
}

		const swiperPartnerWrapperElement = document.querySelector(".swiper-wrapper");
		const pricingQuestionsElement = document.querySelector(".pricing__questions");

if (swiperPartnerWrapperElement && pricingQuestionsElement) {
	      swiperPartnerWrapperElement.style.setProperty('padding-bottom', '64px');
}



function animateCount(el, start, end, duration) {
  let startTs = null;
  function step(ts) {
    if (!startTs) startTs = ts;
    const progress = Math.min((ts - startTs) / duration, 1);
    el.textContent = Math.floor(progress * (end - start) + start) + el.dataset.suffix;
    if (progress < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}

function isMobileDevice() {
  return /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
}

const counterObserver = new IntersectionObserver(
  (entries, observer) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;

      const el = entry.target;
      const initial = parseInt(el.style.getPropertyValue('--initialValue'), 10) || 0;
      const final   = parseInt(el.style.getPropertyValue('--finalValue'), 10) || 0;

      if (isMobileDevice()) {
        animateCount(el, initial, final, 1200);
      } else {
        el.classList.add('in-view');
      }

      observer.unobserve(el);
    });
  },
  { threshold: 0.2 }
);

document.querySelectorAll('.counter').forEach((counter) => {
  counterObserver.observe(counter);
});


