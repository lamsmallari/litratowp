(function() {
  function init() {
    lazyLoadImages_HomePage();
    lazyLoadImages_Archive();
    lazyLoadImages_SinglePage();
    lazyLoadImages_Pages();
    navigation();
    skipLinkFocus();
    homePostSwitcher();
    singlePostLightbox();
    mobileMenu();
  }

  function fadeIn(el, display) {
    el.style.opacity = 0;
    el.style.display = display || "block";

    (function fade() {
      var val = parseFloat(el.style.opacity);
      if (!((val += 0.1) > 1)) {
        el.style.opacity = val;
        requestAnimationFrame(fade);
      }
    })();
  }

  function fadeOut(el) {
    el.style.opacity = 1;

    (function fade() {
      if ((el.style.opacity -= 0.1) < 0) {
        el.style.display = "none";
      } else {
        requestAnimationFrame(fade);
      }
    })();
  }

  function navigation() {
    var container, button, menu, links, i, len;

    container = document.getElementById("site-navigation");
    if (!container) {
      return;
    }

    button = container.getElementsByTagName("button")[0];
    if ("undefined" === typeof button) {
      return;
    }

    menu = container.getElementsByTagName("ul")[0];

    // Hide menu toggle button if menu is empty and return early.
    if ("undefined" === typeof menu) {
      button.style.display = "none";
      return;
    }

    menu.setAttribute("aria-expanded", "false");
    if (-1 === menu.className.indexOf("nav-menu")) {
      menu.className += " nav-menu";
    }

    button.onclick = function() {
      if (-1 !== container.className.indexOf("toggled")) {
        container.className = container.className.replace(" toggled", "");
        button.setAttribute("aria-expanded", "false");
        menu.setAttribute("aria-expanded", "false");
      } else {
        container.className += " toggled";
        button.setAttribute("aria-expanded", "true");
        menu.setAttribute("aria-expanded", "true");
      }
    };

    // Get all the link elements within the menu.
    links = menu.getElementsByTagName("a");

    // Each time a menu link is focused or blurred, toggle focus.
    for (i = 0, len = links.length; i < len; i++) {
      links[i].addEventListener("focus", toggleFocus, true);
      links[i].addEventListener("blur", toggleFocus, true);
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function toggleFocus() {
      var self = this;

      // Move up through the ancestors of the current link until we hit .nav-menu.
      while (-1 === self.className.indexOf("nav-menu")) {
        // On li elements toggle the class .focus.
        if ("li" === self.tagName.toLowerCase()) {
          if (-1 !== self.className.indexOf("focus")) {
            self.className = self.className.replace(" focus", "");
          } else {
            self.className += " focus";
          }
        }

        self = self.parentElement;
      }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    (function(container) {
      var touchStartFn,
        i,
        parentLink = container.querySelectorAll(
          ".menu-item-has-children > a, .page_item_has_children > a"
        );

      if ("ontouchstart" in window) {
        touchStartFn = function(e) {
          var menuItem = this.parentNode,
            i;

          if (!menuItem.classList.contains("focus")) {
            e.preventDefault();
            for (i = 0; i < menuItem.parentNode.children.length; ++i) {
              if (menuItem === menuItem.parentNode.children[i]) {
                continue;
              }
              menuItem.parentNode.children[i].classList.remove("focus");
            }
            menuItem.classList.add("focus");
          } else {
            menuItem.classList.remove("focus");
          }
        };

        for (i = 0; i < parentLink.length; ++i) {
          parentLink[i].addEventListener("touchstart", touchStartFn, false);
        }
      }
    })(container);
  }

  function skipLinkFocus() {
    var isIe = /(trident|msie)/i.test(navigator.userAgent);

    if (isIe && document.getElementById && window.addEventListener) {
      window.addEventListener(
        "hashchange",
        function() {
          var id = location.hash.substring(1),
            element;

          if (!/^[A-z0-9_-]+$/.test(id)) {
            return;
          }

          element = document.getElementById(id);

          if (element) {
            if (
              !/^(?:a|select|input|button|textarea)$/i.test(element.tagName)
            ) {
              element.tabIndex = -1;
            }

            element.focus();
          }
        },
        false
      );
    }
  }

  function lazyLoadImages_HomePage() {
    if (!document.querySelector(".article-lazy")) return;

    // Home: Article BGs
    var articleImage = new LazyLoad({
      elements_selector: ".article-lazy",
      load_delay: "300"
    });
  }

  function lazyLoadImages_SinglePage() {
    if (!document.querySelector(".featured-image-full")) return;

    var singlePostImage = new LazyLoad({
      elements_selector: ".featured-image-full",
      callback_finish: function() {
        setTimeout(function() {
          fadeIn(document.querySelector(".show-image-banner-button"));
        }, 1000);
      }
    });
  }

  function lazyLoadImages_Pages() {
    if (!document.querySelector(".featured-image-full-pages")) return;

    var pagesImage = new LazyLoad({
      elements_selector: ".featured-image-full-pages"
    });
  }

  function lazyLoadImages_Archive() {
    if (!document.querySelector(".archive-banner-image")) return;

    var archivePostImage = new LazyLoad({
      elements_selector: ".archive-banner-image"
    });
  }

  function homePostSwitcher() {
    const articlesContainer = document.getElementById("home-featured-articles");
    const thumbnailsContainer = document.getElementById("home-banner-nav");

    // if elements not exists then exit
    if (!articlesContainer || !thumbnailsContainer) return;

    // select all articles
    const articles = articlesContainer.querySelectorAll("article");

    // set default state
    let state = {
      currentId: "",
      prevId: "",
      fadeIn: fadeIn,
      fadeOut: fadeOut
    };

    function revealArticle(id) {
      state.fadeIn(document.getElementById(id), "flex");

      // get item's info
      const container = document
        .getElementById(id)
        .querySelector(".article-inner");

      // reset item's animation
      container.style = "";

      // reveal item's info
      setTimeout(function() {
        container.style.opacity = "1";
        container.style.transform = "translateY(0)";
      }, 250);
    }

    // INITIAL LOAD ACTIONS
    // set active class on article first-child
    state.currentId = articles[0].getAttribute("id");
    state.prevId = articles[0].getAttribute("id");
    document.getElementById(state.currentId).classList.add("article-active");

    // reveal current article's info
    revealArticle(state.currentId);

    // ON CLICK ACTIONS
    // event listener for thumbnail buttons
    thumbnailsContainer.addEventListener(
      "click",
      function(event) {
        let button = event.target;

        if (
          button.hasAttribute("data-id") ||
          button.parentNode.hasAttribute("data-id")
        ) {
          // get requested article id from thumbnail button data-id
          let postID =
            button.getAttribute("data-id") ||
            button.parentNode.getAttribute("data-id");

          // exit when requesting same article id
          if ("post-" + postID === state.currentId) return;

          // fadeOut current displayed post
          state.fadeOut(document.getElementById(state.currentId));

          // update prevId
          state.prevId = state.currentId;

          // update activeId
          state.currentId = "post-" + postID;

          // update active classes
          document
            .getElementById(state.prevId)
            .classList.remove("article-active");
          document
            .getElementById(state.currentId)
            .classList.add("article-active");

          // fadeIn next target article
          revealArticle(state.currentId);

          event.preventDefault();
          event.stopPropagation();
        }
      },
      false
    );
  }

  function singlePostLightbox() {
    const showImageBannerBtn = document.querySelector(
      ".show-image-banner-button"
    );

    const fullBannerImage = document.querySelector(".banner-lightbox");

    if (!showImageBannerBtn || !fullBannerImage) return;

    showImageBannerBtn.addEventListener("click", function(e) {
      e.preventDefault();
      fadeIn(fullBannerImage);
    });

    fullBannerImage.addEventListener("click", function(e) {
      fadeOut(fullBannerImage);
    });
  }

  function mobileMenu() {
    if (!document.getElementById("mobile-menu-container")) return;

    document.addEventListener("DOMContentLoaded", function() {
      const node = document.querySelector("#mobile-menu-container");
      const menu = new MmenuLight(node, {
        theme: "dark"
      });

      menu.enable("(max-width: 1024px)");
      menu.offcanvas();

      document
        .querySelector("a[href='#my-menu']")
        .addEventListener("click", function(evnt) {
          menu.open();

          // Don't forget to "preventDefault" and to "stopPropagation".
          evnt.preventDefault();
          evnt.stopPropagation();
        });
    });
  }

  init();
})();
