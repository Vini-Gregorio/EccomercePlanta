document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('main-header');
    // Define the scroll position where the header should shrink
    const shrinkOnScroll = 100; // Shrink after scrolling 100px
    const main = document.querySelector('main');

    function adjustMainSpacing() {
        if (!main || !header) return;
        // Ensure the main padding-top equals the current header height so content sits below it
        main.style.paddingTop = header.offsetHeight + 'px';
    }

    function checkScroll() {
        if (window.scrollY >= shrinkOnScroll) {
            header.classList.remove('large-header');
            header.classList.add('small-header');
        } else {
            header.classList.remove('small-header');
            header.classList.add('large-header');
        }
        // update spacing after class change (allows header to collapse/expand)
        adjustMainSpacing();
    }

    // Run once on load (in case the user loads the page mid-scroll)
    checkScroll();

    // Attach listeners
    window.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', adjustMainSpacing);
});