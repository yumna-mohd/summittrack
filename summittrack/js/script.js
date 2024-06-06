// Object to store the state of each container
var containerStates = {};

// Function to show hidden list container
function showHiddenListContainer(listContainerNumber) {
    console.log("Showing hidden list container list number:", listContainerNumber);

    // Freeze background scroll
    document.body.classList.add('freeze-scroll');

    // Show the entire section
    var categorySection = document.getElementById('category_' + listContainerNumber);
    if (categorySection) {
        categorySection.style.display = 'block';
    } else {
        console.error("Category section not found.");
    }

    // Showing the selected container
    var selectedContainer = document.getElementById('hidden-list-container_' + listContainerNumber);
    if (selectedContainer) {
        selectedContainer.style.display = 'block';
        document.getElementById('blur-background').style.display = 'block'; // Show the blur background
        // Updating the container state to open
        containerStates[listContainerNumber] = true;
    } else {
        console.error("Selected container not found.");
    }
}

// Function to close the list container
function closeHiddenListContainer(listContainerNumber) {
    // Unfreeze background scroll
    document.body.classList.remove('freeze-scroll');

    // Hiding the selected container
    var selectedContainer = document.getElementById('hidden-list-container_' + listContainerNumber);
    if (selectedContainer) {
        selectedContainer.style.display = 'none';
        document.getElementById('blur-background').style.display = 'none'; // Hide the blur background
        // Updating the container state to closed
        containerStates[listContainerNumber] = false;
    } else {
        console.error("Selected container not found.");
    }

    // Hide the entire section if all containers are closed
    var allClosed = Object.values(containerStates).every(state => !state);
    if (allClosed) {
        var categorySection = document.getElementById('category_' + listContainerNumber);
        if (categorySection) {
            categorySection.style.display = 'none';
        } else {
            console.error("Category section not found.");
        }
    }
}

// Function that triggers the show hidden list container function when the button is clicked
function toggleAction(listContainerNumber) {
    // Check if the container is already open
    if (containerStates[listContainerNumber]) {
        // If open, close it
        closeHiddenListContainer(listContainerNumber);
    } else {
        // If closed, open it
        showHiddenListContainer(listContainerNumber);
    }
}

//attaching smooth scrolling to anchor tag containing the # 
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

function view_book(id) {
    // Fetching book details from the table row
    let bookNameElement = document.getElementById("bookName-" + id);
    let categoryNameElement = document.getElementById("categoryName-" + id);
    let bookImageElement = document.getElementById("bookImage-" + id);
    let bookAuthorElement = document.getElementById("bookAuthor-" + id);
    let bookSummaryElement = document.getElementById("bookSummary-" + id);

    if (bookNameElement && categoryNameElement && bookImageElement && bookAuthorElement && bookSummaryElement) {
        let viewbookName = bookNameElement.innerText;
        let viewCategoryName = categoryNameElement.innerText;
        let viewbookImage = bookImageElement.src;
        let viewbookAuthor = bookAuthorElement.innerText;
        let viewbookSummary = bookSummaryElement.innerText;

        // Update the content with the fetched data
        document.getElementById("viewbookName").innerText = viewbookName;
        document.getElementById("viewCategoryName").innerText = viewCategoryName;
        document.getElementById("viewbookImage").src = viewbookImage;
        document.getElementById("viewbookAuthor").innerText = viewbookAuthor;
        document.getElementById("viewbookSummary").innerText = viewbookSummary;
    } else {
        console.error("One or more elements not found");
    }
}


// delete book
function delete_book(bookID) {
    if (confirm("Do you confirm to delete this book?")) {
        window.location = "delete-book-logic.php?book=" + bookID;
    }
}

// search
// Function to perform search
function performSearch() {
    console.log("Performing search...");
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("bookListTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        var nameColumn = tr[i].getElementsByTagName("td")[2];
        var categoryColumn = tr[i].getElementsByTagName("td")[3];

        if (nameColumn && categoryColumn) {
            var nameText = nameColumn.textContent || nameColumn.innerText;
            var categoryText = categoryColumn.textContent || categoryColumn.innerText;

            if (nameText.toLowerCase().indexOf(filter) > -1 || categoryText.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// Attaching event listener to the search input field
document.getElementById("searchInput").addEventListener("keyup", performSearch);