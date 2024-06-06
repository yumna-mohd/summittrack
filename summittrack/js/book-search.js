$(document).ready(function() {
    $("#myform").submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var search = $("#books").val();
        if (search == '') {
            alert("Please enter something in the field first");
        } else {
            var url = '';
            var img = '';
            var title = '';
            var author = '';

            $.get("https://www.googleapis.com/books/v1/volumes?q=" + search, function(response) {
                $("#result").empty(); // Clear previous results
                for (var i = 0; i < response.items.length; i++) {
                    // Create a container for each book
                    var bookContainer = $('<div class="book-container"></div>');

                    // get the title of the book
                    title = $('<h5>' + response.items[i].volumeInfo.title + '</h5>');
                    author = $('<h5>' + (response.items[i].volumeInfo.authors ? response.items[i].volumeInfo.authors.join(', ') : 'Unknown Author') + '</h5>');
                    img = $('<img id="dynamic" src="' + (response.items[i].volumeInfo.imageLinks ? response.items[i].volumeInfo.imageLinks.thumbnail : '') + '"><br><a href="' + response.items[i].volumeInfo.infoLink + '"><button id="imagebutton">Read More</button></a>');

                    // Append title, author, and img to the book container
                    bookContainer.append(title, author, img);

                    // Append the book container to the result div
                    $("#result").append(bookContainer);
                }
            });
        }
    });
});
