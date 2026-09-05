(function () {
    'use strict';

    var doc = document;
    var win = window;

    /* ============================================================
       Utilities
       ============================================================ */
    function onReady(fn) {
        if (doc.readyState === 'loading') {
            doc.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    /* ============================================================
       Mobile navigation toggle
       ============================================================ */
    function initMobileNav() {
        var toggle = doc.getElementById('navToggle');
        var menu = doc.getElementById('navLinks');
        if (!toggle || !menu) return;

        function setOpen(open) {
            menu.classList.toggle('open', open);
            toggle.classList.toggle('active', open);
            toggle.setAttribute('aria-expanded', String(open));
        }

        toggle.addEventListener('click', function () {
            setOpen(!menu.classList.contains('open'));
        });

        // Close the menu when a link is clicked
        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                setOpen(false);
            });
        });

        // Close the menu when clicking outside
        doc.addEventListener('click', function (e) {
            if (menu.classList.contains('open') &&
                !menu.contains(e.target) &&
                !toggle.contains(e.target)) {
                setOpen(false);
            }
        });

        // Close on Esc
        doc.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && menu.classList.contains('open')) {
                setOpen(false);
            }
        });
    }

    /* ============================================================
       Smooth scroll (with header offset handled by scroll-padding-top)
       ============================================================ */
    function initSmoothScroll() {
        doc.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var id = link.getAttribute('href');
                if (id.length < 2) return; // bare "#"
                var target = doc.querySelector(id);
                if (!target) return;
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.replaceState(null, null, id);
            });
        });
    }

    /* ============================================================
       Active-section highlighting on scroll
       ============================================================ */
    function initScrollSpy() {
        var links = Array.prototype.slice.call(doc.querySelectorAll('[data-navlink]'));
        if (!links.length) return;

        var sections = links
            .map(function (link) {
                var id = link.getAttribute('href');
                return id.length > 1 ? doc.querySelector(id) : null;
            })
            .filter(Boolean);

        function setActive(id) {
            links.forEach(function (link) {
                var linkId = link.getAttribute('href');
                link.classList.toggle('active', linkId === id);
            });
        }

        // Use IntersectionObserver when available
        if ('IntersectionObserver' in window && sections.length) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        setActive('#' + entry.target.id);
                    }
                });
            }, { rootMargin: '-40% 0px -55% 0px', threshold: 0 });

            sections.forEach(function (section) { observer.observe(section); });
        } else {
            // Fallback: on scroll
            var ticking = false;
            window.addEventListener('scroll', function () {
                if (ticking) return;
                ticking = true;
                window.requestAnimationFrame(function () {
                    var pos = (window.scrollY || doc.documentElement.scrollTop) + 112;
                    sections.forEach(function (section, i) {
                        var top = section.offsetTop;
                        var bottom = top + section.offsetHeight;
                        if (pos >= top && pos < bottom) {
                            setActive('#' + section.id);
                        } else if (i === sections.length - 1 && pos >= bottom) {
                            setActive('#' + section.id);
                        }
                    });
                    ticking = false;
                });
            });
        }
    }

    /* ============================================================
       Reveal-on-scroll animations
       ============================================================ */
    function initReveal() {
        var items = doc.querySelectorAll('.reveal');
        if (!items.length) return;

        if (!('IntersectionObserver' in window)) {
            items.forEach(function (el) { el.classList.add('visible'); });
            return;
        }

        var observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        items.forEach(function (el) { observer.observe(el); });
    }

    /* ============================================================
       Contact form -> mailto
       ============================================================ */
    function initContactForm() {
        var form = doc.getElementById('contactForm');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var mailto = form.getAttribute('data-mailto') || '';
            var val = function (id) {
                var el = doc.getElementById(id);
                return el ? el.value.trim() : '';
            };

            var name = val('name');
            var email = val('email');
            var subject = val('subject') || 'Portfolio contact message';
            var message = val('message');

            if (!name || !message) {
                var firstEmpty = !name ? 'name' : 'message';
                var field = doc.getElementById(firstEmpty);
                if (field) { field.focus(); }
                return;
            }

            var body = 'Name: ' + name + '\nEmail: ' + email + '\n\n' + message;
            var href = 'mailto:' + mailto +
                '?subject=' + encodeURIComponent(subject) +
                '&body=' + encodeURIComponent(body);

            window.location.href = href;
        });
    }

    /* ============================================================
       Profile gallery
       ============================================================ */
    function initGallery() {
        var prev = doc.getElementById('galleryPrev');
        var next = doc.getElementById('galleryNext');
        if (!prev || !next) return;

        var images = Array.prototype.slice.call(doc.querySelectorAll('.about__gallery-img'));
        if (images.length <= 1) return;

        var current = 0;

        function show(index) {
            images[current].classList.remove('active');
            current = (index + images.length) % images.length;
            images[current].classList.add('active');
        }

        prev.addEventListener('click', function () { show(current - 1); });
        next.addEventListener('click', function () { show(current + 1); });
    }

    /* ============================================================
       Project Modal
       ============================================================ */
    function initProjectModal() {
        var overlay = doc.getElementById('projectModal');
        if (!overlay) return;

        var modalTitle = doc.getElementById('modalTitle');
        var modalTechBadge = doc.getElementById('modalTechBadge');
        var modalBrowserLabel = doc.getElementById('modalBrowserLabel');
        var modalSlide = doc.getElementById('modalSlide');
        var modalCaption = doc.getElementById('modalCaption');
        var modalCounter = doc.getElementById('modalCounter');
        var btnPrev = doc.getElementById('modalPrev');
        var btnNext = doc.getElementById('modalNext');
        var btnClose = doc.getElementById('modalClose');

        var projectsData = JSON.parse(overlay.getAttribute('data-projects') || '[]');
        var currentProject = null;
        var currentSlide = 0;

        function openModal(projectIndex) {
            currentProject = projectsData[projectIndex];
            if (!currentProject) return;
            currentSlide = 0;

            modalTitle.textContent = currentProject.title;
            modalTechBadge.textContent = currentProject.tech.join(' / ');
            modalBrowserLabel.textContent = currentProject.title;

            showSlide(0);
            overlay.classList.add('open');
            overlay.setAttribute('aria-hidden', 'false');
            doc.body.style.overflow = 'hidden';
        }

        function closeModal() {
            overlay.classList.remove('open');
            overlay.setAttribute('aria-hidden', 'true');
            doc.body.style.overflow = '';
            currentProject = null;
        }

        function showSlide(index) {
            if (!currentProject) return;
            var screenshots = currentProject.screenshots || [];
            if (!screenshots.length) return;

            currentSlide = (index + screenshots.length) % screenshots.length;
            var shot = screenshots[currentSlide];

            modalSlide.src = shot.src;
            modalSlide.alt = currentProject.title + ' - ' + shot.caption;
            modalCaption.textContent = shot.caption;
            modalCounter.textContent = (currentSlide + 1) + ' / ' + screenshots.length;

            modalSlide.classList.remove('active');
            void modalSlide.offsetWidth;
            modalSlide.classList.add('active');
        }

        doc.querySelectorAll('[data-project-index]').forEach(function (card) {
            card.addEventListener('click', function () {
                openModal(parseInt(card.getAttribute('data-project-index'), 10));
            });
            card.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openModal(parseInt(card.getAttribute('data-project-index'), 10));
                }
            });
        });

        btnClose.addEventListener('click', closeModal);
        btnPrev.addEventListener('click', function () { if (currentProject) showSlide(currentSlide - 1); });
        btnNext.addEventListener('click', function () { if (currentProject) showSlide(currentSlide + 1); });

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });

        doc.addEventListener('keydown', function (e) {
            if (!overlay.classList.contains('open')) return;
            if (e.key === 'Escape') { closeModal(); return; }
            if (e.key === 'ArrowLeft' && currentProject) showSlide(currentSlide - 1);
            if (e.key === 'ArrowRight' && currentProject) showSlide(currentSlide + 1);
        });
    }

    /* ============================================================
       Gallery Modal (profile images)
       ============================================================ */
    function initGalleryModal() {
        var overlay = doc.getElementById('galleryModal');
        if (!overlay) return;

        var galleryImg = doc.getElementById('galleryImg');
        var galleryCounter = doc.getElementById('galleryCounter');
        var btnPrev = doc.getElementById('galleryPrev');
        var btnNext = doc.getElementById('galleryNext');
        var btnClose = doc.getElementById('galleryClose');

        var thumbs = Array.prototype.slice.call(doc.querySelectorAll('.gallery-grid__item'));
        if (!thumbs.length) return;

        var images = thumbs.map(function (t) {
            var img = t.querySelector('img');
            return { src: img ? img.src : '', alt: img ? img.alt : '' };
        });
        var current = 0;

        function show(index) {
            current = (index + images.length) % images.length;
            galleryImg.src = images[current].src;
            galleryImg.alt = images[current].alt;
            galleryCounter.textContent = (current + 1) + ' / ' + images.length;

            galleryImg.classList.remove('active');
            void galleryImg.offsetWidth;
            galleryImg.classList.add('active');
        }

        function openModal(index) {
            current = index;
            show(current);
            overlay.classList.add('open');
            overlay.setAttribute('aria-hidden', 'false');
            doc.body.style.overflow = 'hidden';
        }

        function closeModal() {
            overlay.classList.remove('open');
            overlay.setAttribute('aria-hidden', 'true');
            doc.body.style.overflow = '';
        }

        thumbs.forEach(function (btn, i) {
            btn.addEventListener('click', function () { openModal(i); });
        });

        btnClose.addEventListener('click', closeModal);
        btnPrev.addEventListener('click', function () { show(current - 1); });
        btnNext.addEventListener('click', function () { show(current + 1); });

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });

        doc.addEventListener('keydown', function (e) {
            if (!overlay.classList.contains('open')) return;
            if (e.key === 'Escape') { closeModal(); return; }
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });
    }

    /* ============================================================
       Showcase carousel
       ============================================================ */
    function initShowcase() {
        var viewport = doc.querySelector('.showcase__viewport');
        if (!viewport) return;

        var images = Array.prototype.slice.call(viewport.querySelectorAll('.showcase__img'));
        var label = doc.getElementById('showcaseLabel');
        if (images.length <= 1) return;

        var current = 0;

        function show(index) {
            images[current].classList.remove('active');
            current = (index + images.length) % images.length;
            images[current].classList.add('active');
            if (label) label.textContent = images[current].getAttribute('data-title') || '';
        }

        setInterval(function () { show(current + 1); }, 4000);
    }

    /* ============================================================
       Image viewer (projects & certificates)
       ============================================================ */
    function initImageViewer(prefix, attr) {
        var overlay = doc.getElementById(prefix + 'Viewer');
        var imgEl = doc.getElementById(prefix + 'ViewerImg');
        var close = doc.getElementById(prefix + 'ViewerClose');
        var counter = doc.getElementById(prefix + 'ViewerCounter');
        var btnPrev = doc.getElementById(prefix + 'ViewerPrev');
        var btnNext = doc.getElementById(prefix + 'ViewerNext');
        if (!overlay || !imgEl || !close) return;

        var items = Array.prototype.slice.call(doc.querySelectorAll('[' + attr + ']'));
        if (!items.length) return;
        var current = 0;

        function show(index) {
            current = (index + items.length) % items.length;
            var el = items[current];
            imgEl.src = el.getAttribute(attr);
            imgEl.alt = el.getAttribute('aria-label') || '';
            if (counter) counter.textContent = (current + 1) + ' / ' + items.length;
            imgEl.classList.remove('active');
            void imgEl.offsetWidth;
            imgEl.classList.add('active');
        }

        items.forEach(function (el, i) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                show(i);
                overlay.classList.add('open');
                overlay.setAttribute('aria-hidden', 'false');
                doc.body.style.overflow = 'hidden';
            });
        });

        if (btnPrev) btnPrev.addEventListener('click', function () { show(current - 1); });
        if (btnNext) btnNext.addEventListener('click', function () { show(current + 1); });

        function closeViewer() {
            overlay.classList.remove('open');
            overlay.setAttribute('aria-hidden', 'true');
            doc.body.style.overflow = '';
        }
        close.addEventListener('click', closeViewer);
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeViewer();
        });
        doc.addEventListener('keydown', function (e) {
            if (!overlay.classList.contains('open')) return;
            if (e.key === 'Escape') { closeViewer(); return; }
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });
    }

    /* ============================================================
       See More Projects toggle
       ============================================================ */
    function initMoreProjects() {
        var wrapper = doc.querySelector('.more-projects');
        var toggle = wrapper && wrapper.querySelector('.more-projects__toggle');
        if (!wrapper || !toggle) return;

        toggle.addEventListener('click', function () {
            var open = wrapper.classList.toggle('more-projects--open');
            toggle.setAttribute('aria-expanded', String(open));

            if (open) {
                wrapper.querySelectorAll('.more-projects__item').forEach(function (el) {
                    el.classList.add('visible');
                });
            }

            toggle.textContent = open ? 'See Less Projects' : 'See More Projects';
        });
    }

    /* ============================================================
       Back to top
       ============================================================ */
    function initBackToTop() {
        var btn = doc.getElementById('backToTop');
        if (!btn) return;

        function toggle() {
            btn.classList.toggle('is-visible', win.scrollY > 300);
        }

        win.addEventListener('scroll', toggle, { passive: true });
        toggle();

        btn.addEventListener('click', function () {
            win.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ============================================================
       Init on DOM ready
       ============================================================ */
    onReady(function () {
        initMobileNav();
        initSmoothScroll();
        initScrollSpy();
        initReveal();
        initContactForm();
        initGallery();
        initProjectModal();
        initGalleryModal();
        initShowcase();
        initMoreProjects();
        initImageViewer('cert', 'data-cert-image');
        initImageViewer('project', 'data-project-image');
        initBackToTop();
    });
})();
