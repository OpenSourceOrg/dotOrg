document.addEventListener('DOMContentLoaded', function () {
    // Select the discource div with the class 'wpdc-join-discussion'
    const discussionDiv = document.querySelector('.wpdc-join-discussion');

    // Check if the element exists
    if (discussionDiv) {
        const heading = document.createElement('h3');
        heading.classList.add('wp-block-heading');
        heading.textContent = 'Join the discussion on Discourse!';
        discussionDiv.insertBefore(heading, discussionDiv.firstChild);
    }
});
