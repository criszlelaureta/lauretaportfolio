@props(['projects' => []])

<div class="modal-overlay" id="projectModal" role="dialog" aria-modal="true" aria-hidden="true" data-projects="{{ json_encode($projects) }}">
    <div class="modal">
        <div class="modal__header">
            <h2 class="modal__title" id="modalTitle"></h2>
            <button class="modal__close" id="modalClose" aria-label="Close modal">&times;</button>
        </div>

        <span class="modal__tech-badge" id="modalTechBadge"></span>

        <div class="modal__browser">
            <div class="modal__browser-bar">
                <span class="modal__browser-label" id="modalBrowserLabel"></span>
                <span class="modal__browser-close" aria-hidden="true">&times;</span>
            </div>
            <div class="modal__browser-viewport">
                <img src="" alt="" class="modal__slide" id="modalSlide" />
            </div>
        </div>

        <button class="modal__arrow modal__arrow--prev" id="modalPrev" aria-label="Previous screenshot">&#10094;</button>
        <button class="modal__arrow modal__arrow--next" id="modalNext" aria-label="Next screenshot">&#10095;</button>

        <div class="modal__footer">
            <span class="modal__caption" id="modalCaption"></span>
            <span class="modal__counter" id="modalCounter"></span>
        </div>
    </div>
</div>
