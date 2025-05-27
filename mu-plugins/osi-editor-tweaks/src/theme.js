/**
 * Initialize event listeners for the animated titles.
 *
 * @returns {void}
 */
const initAnimatedElements = () => {
  // Function to check if an element is in the viewport
  const isInViewport = (element) => {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  };

  // Function to add 'visible' class if element is in the viewport
  const checkVisibility = () => {
    document.querySelectorAll('.wp-block-heading.slide-up, p.slide-up').forEach(el => {
      if (isInViewport(el)) {
        el.classList.add('visible');
      }
    });
  };

  // Select all headings you want to monitor
  const headings = document.querySelectorAll('.wp-block-heading.slide-up, p.slide-up');
console.log(headings.length);

  // Create an IntersectionObserver instance
  const intersectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  });

  // Observe each heading
  headings.forEach(heading => {
    intersectionObserver.observe(heading);
  });

  // Create a MutationObserver to watch for new headings
  const mutationObserver = new MutationObserver((mutationsList) => {
    for (const mutation of mutationsList) {
      if (mutation.type === 'childList') {
        // Check if new nodes were added
        mutation.addedNodes.forEach(node => {
          if (node.nodeType === Node.ELEMENT_NODE) {
            // If a new heading is added, observe it
            if (node.classList.contains('wp-block-heading') && node.classList.contains('slide-up')) {
              intersectionObserver.observe(node);
            }

            // Check for headings added inside newly added elements
            const newHeadings = node.querySelectorAll ? node.querySelectorAll('.wp-block-heading.slide-up') : [];
            newHeadings.forEach(heading => {
              intersectionObserver.observe(heading);
            });
          }
        });
      }
    }
  });

  // Observe the entire document for changes
  mutationObserver.observe(document.body, {
    childList: true,
    subtree: true
  });

  // Initial check in case elements are already in view
  checkVisibility();
};


// Initialize observers when the DOM content is loaded
document.addEventListener("DOMContentLoaded", initAnimatedElements);
