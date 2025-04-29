// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", function () {
    // If the URL contains a search parameter (?s=) and a hash (#), remove the hash from the URL
    if (window.location.search.includes("?s=") && window.location.hash) {
        history.replaceState(null, "", window.location.href.split('#')[0]);
    }

    // Wait for the page to fully load
    window.addEventListener("load", function () {
        // Check if there is a hash stored in sessionStorage for scrolling
        let scrollToHash = sessionStorage.getItem("scrollToHash");
        if (scrollToHash) {
            sessionStorage.removeItem("scrollToHash"); // Remove the stored hash
            document.querySelector(scrollToHash)?.scrollIntoView({ behavior: "smooth" }); // Smooth scroll to the element
        }

        // Get the current hash from the URL
        let currentHash = window.location.hash;
        if (currentHash) {
            // Highlight the corresponding letter based on the hash
            document.querySelectorAll(".available-letter").forEach(link => {
                link.classList.remove("active-letter"); // Remove active class from all letters
                if (link.getAttribute("href") === currentHash) {
                    link.classList.add("active-letter"); // Add active class to the matching letter
                }
            });
        } else {
            // If no hash is present, set the "All" option as active
            document.querySelector(".all").classList.add("active-letter");
        }
    });
});

// Add click event listeners to all elements with the class "available-letter"
document.querySelectorAll(".available-letter").forEach(function (link) {
    link.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default link behavior

        // Remove the active class from all letters
        document.querySelectorAll(".available-letter").forEach(function (letter) {
            letter.classList.remove("active-letter");
        });

        // Add the active class to the clicked letter
        link.classList.add("active-letter");

        // Handle the hash in the URL
        let url = new URL(window.location.href);
        let hasSParam = url.searchParams.has("s"); // Check if the 's' parameter exists
        url.searchParams.delete("s"); // Remove the 's' parameter

        // If the link's href is "#", clear the hash in the URL
        if (link.getAttribute("href") === "#") {
            url.hash = ""; // Remove the hash
        } else {
            url.hash = link.getAttribute("href"); // Set the hash from the link
        }

        // Handle scrolling and URL changes based on the presence of the 's' parameter
        if (hasSParam) {
            sessionStorage.setItem("scrollToHash", url.hash); // Save the hash for scrolling after reload
            window.location.href = url.toString(); // Reload the page with the updated URL
        } else {
            history.replaceState(null, "", url.toString()); // Update the URL without reloading the page

            // Escape the hash to make it a valid CSS selector
            if (url.hash) {
                const escapedHash = CSS.escape(url.hash.slice(1)); // Remove the "#" and escape the rest
                const targetElement = document.querySelector(`#${escapedHash}`); // Find the target element
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: "smooth" }); // Smooth scroll to the target element
                }
            }
        }
    });
});