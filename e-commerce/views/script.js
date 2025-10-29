document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('main-header');
    // Define the scroll position where the header should shrink
    const shrinkOnScroll = 100; // Shrink after scrolling 100px

    function checkScroll() {
        // window.scrollY is the current vertical scroll position
        if (window.scrollY >= shrinkOnScroll) {
            // Add the class to shrink
            header.classList.remove('large-header');
            header.classList.add('small-header');
        } else {
            // Remove the class to expand
            header.classList.remove('small-header');
            header.classList.add('large-header');
        }
    }

    // Run the function once on load (in case the user loads the page mid-scroll)
    checkScroll();

    // Attach the function to the scroll event for constant checking
    window.addEventListener('scroll', checkScroll);
});